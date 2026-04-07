<?php

namespace App\Services;

use App\Models\Articulo;
use App\Models\VentaItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\InsufficientStockException;

class StockService
{
    /**
     * Verificar si hay stock suficiente para un artículo
     */
    public function verificarStock(int $articuloId, int $cantidad): bool
    {
        $articulo = Articulo::find($articuloId);
        
        if (!$articulo) {
            return false;
        }
        
        return $articulo->stock >= $cantidad;
    }

    /**
     * Obtener stock disponible de un artículo
     */
    public function getStockDisponible(int $articuloId): int
    {
        $articulo = Articulo::find($articuloId);
        
        return $articulo ? $articulo->stock : 0;
    }

    /**
     * Reducir stock de un artículo con lock pesimista
     */
    public function reducirStock(int $articuloId, int $cantidad, string $motivo = 'venta'): void
    {
        DB::transaction(function () use ($articuloId, $cantidad, $motivo) {
            $articulo = Articulo::lockForUpdate()->find($articuloId);
            
            if (!$articulo) {
                throw new \Exception("Artículo con ID {$articuloId} no encontrado");
            }
            
            if ($articulo->stock < $cantidad) {
                throw new InsufficientStockException(
                    "Stock insuficiente para el artículo {$articulo->nombre}. " .
                    "Stock disponible: {$articulo->stock}, solicitado: {$cantidad}"
                );
            }
            
            $stockAnterior = $articulo->stock;
            $articulo->decrement('stock', $cantidad);
            
            Log::info('Stock reducido', [
                'articulo_id' => $articuloId,
                'articulo_nombre' => $articulo->nombre,
                'cantidad' => $cantidad,
                'stock_anterior' => $stockAnterior,
                'stock_nuevo' => $articulo->fresh()->stock,
                'motivo' => $motivo,
                'user_id' => auth()->id()
            ]);
        });
    }

    /**
     * Restaurar stock de un artículo
     */
    public function restaurarStock(int $articuloId, int $cantidad, string $motivo = 'cancelacion_venta'): void
    {
        DB::transaction(function () use ($articuloId, $cantidad, $motivo) {
            $articulo = Articulo::lockForUpdate()->find($articuloId);
            
            if (!$articulo) {
                throw new \Exception("Artículo con ID {$articuloId} no encontrado");
            }
            
            $stockAnterior = $articulo->stock;
            $articulo->increment('stock', $cantidad);
            
            Log::info('Stock restaurado', [
                'articulo_id' => $articuloId,
                'articulo_nombre' => $articulo->nombre,
                'cantidad' => $cantidad,
                'stock_anterior' => $stockAnterior,
                'stock_nuevo' => $articulo->fresh()->stock,
                'motivo' => $motivo,
                'user_id' => auth()->id()
            ]);
        });
    }

    /**
     * Verificar stock para múltiples artículos
     */
    public function verificarStockMultiple(array $items): array
    {
        $errores = [];
        
        foreach ($items as $item) {
            $articuloId = $item['articulo_id'];
            $cantidad = $item['cantidad'];
            
            if (!$this->verificarStock($articuloId, $cantidad)) {
                $articulo = Articulo::find($articuloId);
                $stockDisponible = $articulo ? $articulo->stock : 0;
                
                $errores[] = [
                    'articulo_id' => $articuloId,
                    'articulo_nombre' => $articulo ? $articulo->nombre : 'Desconocido',
                    'cantidad_solicitada' => $cantidad,
                    'stock_disponible' => $stockDisponible
                ];
            }
        }
        
        return $errores;
    }

    /**
     * Obtener artículos con stock bajo
     */
    public function getArticulosStockBajo(int $umbral = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Articulo::where('stock', '>', 0)
            ->where('stock', '<=', $umbral)
            ->orderBy('stock', 'asc')
            ->get();
    }

    /**
     * Obtener artículos sin stock
     */
    public function getArticulosSinStock(): \Illuminate\Database\Eloquent\Collection
    {
        return Articulo::where('stock', 0)
            ->orderBy('nombre')
            ->get();
    }

    /**
     * Obtener estadísticas de stock
     */
    public function getEstadisticasStock(): array
    {
        $stats = DB::table('articulos')
            ->selectRaw('
                COUNT(*) as total_articulos,
                SUM(stock) as stock_total,
                COUNT(CASE WHEN stock = 0 THEN 1 END) as sin_stock,
                COUNT(CASE WHEN stock > 0 AND stock <= 5 THEN 1 END) as stock_critico,
                COUNT(CASE WHEN stock > 5 AND stock <= 20 THEN 1 END) as stock_bajo,
                COUNT(CASE WHEN stock > 20 THEN 1 END) as stock_normal
            ')
            ->first();

        return [
            'total_articulos' => $stats->total_articulos ?? 0,
            'stock_total' => $stats->stock_total ?? 0,
            'sin_stock' => $stats->sin_stock ?? 0,
            'stock_critico' => $stats->stock_critico ?? 0,
            'stock_bajo' => $stats->stock_bajo ?? 0,
            'stock_normal' => $stats->stock_normal ?? 0,
        ];
    }
}
