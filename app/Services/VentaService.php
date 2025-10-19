<?php

namespace App\Services;

use App\Models\Venta;
use App\Models\VentaItem;
use App\Models\Articulo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Exceptions\InsufficientStockException;
use App\Exceptions\VentaException;

class VentaService
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * Crear una nueva venta con validación de stock
     */
    public function crearVenta(array $datosVenta, array $items): Venta
    {
        try {
            Log::info('Iniciando creación de venta', [
                'cliente' => $datosVenta['cliente_nombre'],
                'items_count' => count($items),
                'user_id' => Auth::id()
            ]);

            return DB::transaction(function () use ($datosVenta, $items) {
                // 1. Validar stock para todos los artículos
                $erroresStock = $this->stockService->verificarStockMultiple($items);
                
                if (!empty($erroresStock)) {
                    $mensaje = 'Stock insuficiente para los siguientes artículos: ';
                    $mensaje .= collect($erroresStock)->map(function ($error) {
                        return "{$error['articulo_nombre']} (disponible: {$error['stock_disponible']}, solicitado: {$error['cantidad_solicitada']})";
                    })->join(', ');
                    
                    throw new InsufficientStockException($mensaje);
                }

                // 2. Calcular total de la venta
                $total = $this->calcularTotalVenta($items);

                // 3. Crear la venta
                $venta = Venta::create([
                    'user_id' => Auth::id(),
                    'cliente_nombre' => $datosVenta['cliente_nombre'],
                    'total' => $total,
                    'fecha_venta' => now(),
                    'notas' => $datosVenta['notas'] ?? null,
                ]);

                // 4. Crear items y reducir stock
                foreach ($items as $item) {
                    $this->crearItemVenta($venta->id, $item);
                }

                Log::info('Venta creada exitosamente', [
                    'venta_id' => $venta->id,
                    'total' => $total,
                    'items_count' => count($items)
                ]);

                return $venta->load(['user', 'items.articulo']);
            });

        } catch (\Exception $e) {
            Log::error('Error al crear venta', [
                'error' => $e->getMessage(),
                'cliente' => $datosVenta['cliente_nombre'] ?? 'N/A',
                'items_count' => count($items),
                'user_id' => Auth::id()
            ]);
            
            throw $e;
        }
    }

    /**
     * Actualizar una venta existente
     */
    public function actualizarVenta(int $ventaId, array $datosVenta, array $items): Venta
    {
        try {
            Log::info('Iniciando actualización de venta', [
                'venta_id' => $ventaId,
                'cliente' => $datosVenta['cliente_nombre'],
                'items_count' => count($items),
                'user_id' => Auth::id()
            ]);

            return DB::transaction(function () use ($ventaId, $datosVenta, $items) {
                $venta = Venta::with('items')->findOrFail($ventaId);
                
                // 1. Restaurar stock de items originales
                foreach ($venta->items as $itemOriginal) {
                    $this->stockService->restaurarStock(
                        $itemOriginal->articulo_id,
                        $itemOriginal->cantidad,
                        "actualizacion_venta_id_{$ventaId}"
                    );
                }

                // 2. Validar stock para los nuevos items
                $erroresStock = $this->stockService->verificarStockMultiple($items);
                
                if (!empty($erroresStock)) {
                    // Si hay errores, restaurar el stock original
                    foreach ($venta->items as $itemOriginal) {
                        $this->stockService->reducirStock(
                            $itemOriginal->articulo_id,
                            $itemOriginal->cantidad,
                            "rollback_actualizacion_venta_id_{$ventaId}"
                        );
                    }
                    
                    $mensaje = 'Stock insuficiente para los siguientes artículos: ';
                    $mensaje .= collect($erroresStock)->map(function ($error) {
                        return "{$error['articulo_nombre']} (disponible: {$error['stock_disponible']}, solicitado: {$error['cantidad_solicitada']})";
                    })->join(', ');
                    
                    throw new InsufficientStockException($mensaje);
                }

                // 3. Calcular nuevo total
                $total = $this->calcularTotalVenta($items);

                // 4. Actualizar datos de la venta
                $venta->update([
                    'cliente_nombre' => $datosVenta['cliente_nombre'],
                    'total' => $total,
                    'notas' => $datosVenta['notas'] ?? null,
                ]);

                // 5. Eliminar items originales
                $venta->items()->delete();

                // 6. Crear nuevos items y reducir stock
                foreach ($items as $item) {
                    $this->crearItemVenta($venta->id, $item);
                }

                Log::info('Venta actualizada exitosamente', [
                    'venta_id' => $venta->id,
                    'total' => $total,
                    'items_count' => count($items)
                ]);

                return $venta->load(['user', 'items.articulo']);
            });

        } catch (\Exception $e) {
            Log::error('Error al actualizar venta', [
                'venta_id' => $ventaId,
                'error' => $e->getMessage(),
                'cliente' => $datosVenta['cliente_nombre'] ?? 'N/A',
                'items_count' => count($items),
                'user_id' => Auth::id()
            ]);
            
            throw $e;
        }
    }

    /**
     * Crear un item de venta y reducir stock
     */
    protected function crearItemVenta(int $ventaId, array $item): VentaItem
    {
        $subtotal = $item['cantidad'] * $item['precio_unitario'];
        
        // Reducir stock con lock pesimista
        $this->stockService->reducirStock(
            $item['articulo_id'], 
            $item['cantidad'], 
            "venta_id_{$ventaId}"
        );

        // Crear el item de venta
        $ventaItem = VentaItem::create([
            'venta_id' => $ventaId,
            'articulo_id' => $item['articulo_id'],
            'cantidad' => $item['cantidad'],
            'precio_unitario' => $item['precio_unitario'],
            'subtotal' => $subtotal,
            'detalle' => $item['detalle'] ?? null,
        ]);

        return $ventaItem;
    }

    /**
     * Calcular el total de una venta
     */
    public function calcularTotalVenta(array $items): float
    {
        $total = 0;
        
        foreach ($items as $item) {
            $subtotal = $item['cantidad'] * $item['precio_unitario'];
            $total += $subtotal;
        }
        
        return $total;
    }

    /**
     * Eliminar una venta y restaurar stock
     */
    public function eliminarVenta(int $ventaId): bool
    {
        try {
            Log::info('Iniciando eliminación de venta', [
                'venta_id' => $ventaId,
                'user_id' => Auth::id()
            ]);

            return DB::transaction(function () use ($ventaId) {
                $venta = Venta::with('items')->findOrFail($ventaId);
                
                // Restaurar stock de todos los items
                foreach ($venta->items as $item) {
                    $this->stockService->restaurarStock(
                        $item->articulo_id,
                        $item->cantidad,
                        "eliminacion_venta_id_{$ventaId}"
                    );
                }

                // Eliminar la venta (los items se eliminarán por cascade)
                $venta->delete();

                Log::info('Venta eliminada exitosamente', [
                    'venta_id' => $ventaId,
                    'items_restaurados' => $venta->items->count()
                ]);

                return true;
            });

        } catch (\Exception $e) {
            Log::error('Error al eliminar venta', [
                'venta_id' => $ventaId,
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);
            
            throw $e;
        }
    }

    /**
     * Obtener ventas con filtros optimizados
     */
    public function getVentasConFiltros(array $filtros = [], int $perPage = 15)
    {
        return Venta::getOptimizedList($filtros, $perPage);
    }

    /**
     * Obtener estadísticas de ventas
     */
    public function getEstadisticasVentas($fechaInicio = null, $fechaFin = null): array
    {
        return Venta::getEstadisticas($fechaInicio, $fechaFin);
    }

    /**
     * Validar items de venta
     */
    public function validarItemsVenta(array $items): array
    {
        $errores = [];

        foreach ($items as $index => $item) {
            // Validar que el artículo existe
            $articulo = Articulo::find($item['articulo_id']);
            if (!$articulo) {
                $errores[] = "Item {$index}: Artículo no encontrado";
                continue;
            }

            // Validar cantidad
            if ($item['cantidad'] <= 0) {
                $errores[] = "Item {$index}: La cantidad debe ser mayor a 0";
            }

            // Validar precio
            if ($item['precio_unitario'] <= 0) {
                $errores[] = "Item {$index}: El precio debe ser mayor a 0";
            }

            // Validar stock disponible
            if (!$this->stockService->verificarStock($item['articulo_id'], $item['cantidad'])) {
                $stockDisponible = $this->stockService->getStockDisponible($item['articulo_id']);
                $errores[] = "Item {$index}: Stock insuficiente para '{$articulo->nombre}'. Disponible: {$stockDisponible}, Solicitado: {$item['cantidad']}";
            }
        }

        return $errores;
    }

    /**
     * Obtener ventas por artículo
     */
    public function getVentasPorArticulo(int $articuloId, int $perPage = 15)
    {
        return Venta::byArticulo($articuloId)->paginate($perPage);
    }

    /**
     * Obtener ventas por cliente
     */
    public function getVentasPorCliente(string $cliente, int $perPage = 15)
    {
        return Venta::byCliente($cliente)->paginate($perPage);
    }

    /**
     * Obtener ventas por rango de fechas
     */
    public function getVentasPorFechas($fechaInicio, $fechaFin, int $perPage = 15)
    {
        return Venta::byFecha($fechaInicio, $fechaFin)->paginate($perPage);
    }

    /**
     * Obtener resumen de ventas del día
     */
    public function getResumenVentasDelDia(): array
    {
        $hoy = now()->toDateString();
        
        $ventas = Venta::whereDate('fecha_venta', $hoy)->get();
        
        return [
            'total_ventas' => $ventas->count(),
            'total_monto' => $ventas->sum('total'),
            'promedio_venta' => $ventas->count() > 0 ? $ventas->avg('total') : 0,
            'ventas' => $ventas
        ];
    }

    /**
     * Obtener artículos más vendidos
     */
    public function getArticulosMasVendidos(int $limite = 10): \Illuminate\Support\Collection
    {
        return VentaItem::select('articulo_id')
            ->selectRaw('SUM(cantidad) as total_vendido')
            ->with('articulo:id,nombre,codigo')
            ->groupBy('articulo_id')
            ->orderBy('total_vendido', 'desc')
            ->limit($limite)
            ->get();
    }
}
