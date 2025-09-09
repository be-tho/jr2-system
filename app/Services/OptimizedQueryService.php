<?php

namespace App\Services;

use App\Models\Articulo;
use App\Models\Corte;
use App\Models\Categoria;
use App\Models\Temporada;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class OptimizedQueryService
{
    private const CACHE_TTL = 300; // 5 minutos

    /**
     * Obtener estadísticas optimizadas con una sola consulta
     */
    public function getOptimizedStats(): array
    {
        return Cache::remember('optimized_stats', self::CACHE_TTL, function () {
            $stats = DB::select("
                SELECT 
                    (SELECT COUNT(*) FROM articulos) as total_articulos,
                    (SELECT SUM(stock) FROM articulos) as stock_total,
                    (SELECT SUM(precio * stock) FROM articulos) as valor_total_inventario,
                    (SELECT COUNT(*) FROM articulos WHERE stock = 0) as articulos_sin_stock,
                    (SELECT COUNT(*) FROM articulos WHERE stock > 0 AND stock <= 10) as articulos_stock_bajo,
                    (SELECT COUNT(*) FROM cortes) as total_cortes,
                    (SELECT COUNT(*) FROM cortes WHERE estado IN (0, 1)) as cortes_pendientes,
                    (SELECT COUNT(*) FROM categoria) as categorias_activas,
                    (SELECT COUNT(*) FROM temporada) as temporadas_activas
            ")[0];

            return [
                'total_articulos' => $stats->total_articulos ?? 0,
                'stock_total' => $stats->stock_total ?? 0,
                'valor_total_inventario' => $stats->valor_total_inventario ?? 0,
                'articulos_sin_stock' => $stats->articulos_sin_stock ?? 0,
                'articulos_stock_bajo' => $stats->articulos_stock_bajo ?? 0,
                'total_cortes' => $stats->total_cortes ?? 0,
                'cortes_pendientes' => $stats->cortes_pendientes ?? 0,
                'categorias_activas' => $stats->categorias_activas ?? 0,
                'temporadas_activas' => $stats->temporadas_activas ?? 0,
            ];
        });
    }

    /**
     * Obtener artículos con relaciones optimizadas usando JOIN
     */
    public function getArticulosWithRelationsOptimized(array $filters = [], int $perPage = 12)
    {
        $query = DB::table('articulos')
            ->select([
                'articulos.id',
                'articulos.nombre',
                'articulos.codigo',
                'articulos.precio',
                'articulos.stock',
                'articulos.imagen',
                'articulos.created_at',
                'categoria.nombre as categoria_nombre',
                'temporada.nombre as temporada_nombre'
            ])
            ->leftJoin('categoria', 'articulos.categoria_id', '=', 'categoria.id')
            ->leftJoin('temporada', 'articulos.temporada_id', '=', 'temporada.id');

        // Aplicar filtros
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('articulos.nombre', 'like', "%{$filters['search']}%")
                  ->orWhere('articulos.descripcion', 'like', "%{$filters['search']}%")
                  ->orWhere('articulos.codigo', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['categoria_id'])) {
            $query->where('articulos.categoria_id', $filters['categoria_id']);
        }

        if (!empty($filters['temporada_id'])) {
            $query->where('articulos.temporada_id', $filters['temporada_id']);
        }

        // Aplicar ordenamiento
        $orderBy = $filters['order_by'] ?? 'created_at';
        $orderDirection = $filters['order_direction'] ?? 'desc';
        
        if ($orderBy === 'categoria') {
            $query->orderBy('categoria.nombre', $orderDirection);
        } elseif ($orderBy === 'temporada') {
            $query->orderBy('temporada.nombre', $orderDirection);
        } else {
            $query->orderBy("articulos.{$orderBy}", $orderDirection);
        }

        return $query->paginate($perPage);
    }

    /**
     * Obtener cortes con estadísticas optimizadas
     */
    public function getCortesWithStatsOptimized(array $filters = [], int $perPage = 12)
    {
        $query = DB::table('cortes')
            ->select([
                'id',
                'numero_corte',
                'tipo_tela',
                'colores',
                'cantidad_total',
                'articulos',
                'descripcion',
                'costureros',
                'estado',
                'imagen',
                'imagen_alt',
                'fecha',
                'created_at'
            ]);

        // Aplicar filtros
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('numero_corte', 'like', "%{$filters['search']}%")
                  ->orWhere('descripcion', 'like', "%{$filters['search']}%")
                  ->orWhere('tipo_tela', 'like', "%{$filters['search']}%");
            });
        }

        if (isset($filters['estado']) && $filters['estado'] !== '') {
            $query->where('estado', $filters['estado']);
        }

        if (!empty($filters['fecha_desde'])) {
            $query->whereDate('fecha', '>=', $filters['fecha_desde']);
        }

        if (!empty($filters['fecha_hasta'])) {
            $query->whereDate('fecha', '<=', $filters['fecha_hasta']);
        }

        // Aplicar ordenamiento
        $orderBy = $filters['order_by'] ?? 'created_at';
        $orderDirection = $filters['order_direction'] ?? 'desc';
        $query->orderBy($orderBy, $orderDirection);

        return $query->paginate($perPage);
    }

    /**
     * Obtener datos para formularios con caché optimizado
     */
    public function getFormData(): array
    {
        return Cache::remember('form_data', self::CACHE_TTL, function () {
            return [
                'categorias' => Categoria::select('id', 'nombre')->orderBy('nombre')->get(),
                'temporadas' => Temporada::select('id', 'nombre')->orderBy('nombre')->get(),
            ];
        });
    }

    /**
     * Obtener artículos populares optimizado
     */
    public function getPopularArticulos(int $limit = 5)
    {
        return Cache::remember("popular_articulos_{$limit}", self::CACHE_TTL, function () use ($limit) {
            return Articulo::select('id', 'nombre', 'codigo', 'precio', 'stock', 'imagen')
                ->orderBy('stock', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Obtener cortes recientes optimizado
     */
    public function getRecentCortes(int $limit = 5)
    {
        return Cache::remember("recent_cortes_{$limit}", self::CACHE_TTL, function () use ($limit) {
            return Corte::select('id', 'numero_corte', 'tipo_tela', 'cantidad_total', 'estado', 'fecha', 'imagen')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Limpiar todos los cachés relacionados
     */
    public function clearAllCaches(): void
    {
        Cache::forget('optimized_stats');
        Cache::forget('form_data');
        Cache::forget('categorias_for_filters');
        Cache::forget('categorias_for_form');
        Cache::forget('temporadas_for_filters');
        Cache::forget('temporadas_for_form');
        
        // Limpiar cachés de artículos populares
        for ($i = 1; $i <= 20; $i++) {
            Cache::forget("popular_articulos_{$i}");
        }
        
        // Limpiar cachés de cortes recientes
        for ($i = 1; $i <= 20; $i++) {
            Cache::forget("recent_cortes_{$i}");
        }
    }

    /**
     * Obtener estadísticas de rendimiento con consultas optimizadas
     */
    public function getPerformanceStatsOptimized(): array
    {
        return Cache::remember('performance_stats_optimized', self::CACHE_TTL, function () {
            // Estadísticas de artículos por categoría
            $articulosPorCategoria = DB::table('articulos')
                ->join('categoria', 'articulos.categoria_id', '=', 'categoria.id')
                ->select('categoria.nombre as categoria')
                ->selectRaw('COUNT(*) as cantidad, AVG(articulos.precio) as precio_promedio')
                ->groupBy('categoria.id', 'categoria.nombre')
                ->orderBy('cantidad', 'desc')
                ->limit(5)
                ->get();

            // Estadísticas de cortes por mes (últimos 6 meses)
            $cortesPorMes = DB::table('cortes')
                ->selectRaw('
                    DATE_FORMAT(fecha, "%Y-%m") as mes,
                    COUNT(*) as cantidad,
                    SUM(cantidad_total) as total_articulos
                ')
                ->where('fecha', '>=', now()->subMonths(6))
                ->groupBy('mes')
                ->orderBy('mes')
                ->get();

            // Estadísticas de stock
            $stockStats = DB::table('articulos')
                ->selectRaw('
                    COUNT(CASE WHEN stock = 0 THEN 1 END) as sin_stock,
                    COUNT(CASE WHEN stock > 0 AND stock <= 5 THEN 1 END) as stock_critico,
                    COUNT(CASE WHEN stock > 5 AND stock <= 20 THEN 1 END) as stock_bajo,
                    COUNT(CASE WHEN stock > 20 THEN 1 END) as stock_normal
                ')
                ->first();

            return [
                'articulos_por_categoria' => $articulosPorCategoria,
                'cortes_por_mes' => $cortesPorMes,
                'stock_stats' => [
                    'sin_stock' => $stockStats->sin_stock ?? 0,
                    'stock_critico' => $stockStats->stock_critico ?? 0,
                    'stock_bajo' => $stockStats->stock_bajo ?? 0,
                    'stock_normal' => $stockStats->stock_normal ?? 0,
                ],
            ];
        });
    }
}
