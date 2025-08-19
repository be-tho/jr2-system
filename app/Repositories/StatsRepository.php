<?php

namespace App\Repositories;

use App\Models\Articulo;
use App\Models\Corte;
use App\Models\Categoria;
use App\Models\Temporada;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class StatsRepository
{
    private const CACHE_TTL = 300; // 5 minutos

    /**
     * Obtener estadísticas generales del sistema
     */
    public function getGeneralStats(): array
    {
        return Cache::remember('general_stats', self::CACHE_TTL, function () {
            return $this->calculateGeneralStats();
        });
    }

    /**
     * Calcular estadísticas generales
     */
    private function calculateGeneralStats(): array
    {
        // Obtener estadísticas de artículos
        $articulosStats = DB::table('articulos')
            ->selectRaw('
                COUNT(*) as total_articulos,
                SUM(stock) as stock_total,
                SUM(precio * stock) as valor_total_inventario,
                COUNT(CASE WHEN stock = 0 THEN 1 END) as articulos_sin_stock
            ')
            ->first();

        // Obtener estadísticas de cortes
        $cortesStats = DB::table('cortes')
            ->selectRaw('
                COUNT(*) as total_cortes,
                COUNT(CASE WHEN estado IN (0, 1) THEN 1 END) as cortes_pendientes
            ')
            ->first();

        // Obtener estadísticas de categorías y temporadas
        $categoriasCount = Categoria::count();
        $temporadasCount = Temporada::count();

        return [
            'total_articulos' => $articulosStats->total_articulos ?? 0,
            'stock_total' => $articulosStats->stock_total ?? 0,
            'valor_total_inventario' => $articulosStats->valor_total_inventario ?? 0,
            'articulos_sin_stock' => $articulosStats->articulos_sin_stock ?? 0,
            'total_cortes' => $cortesStats->total_cortes ?? 0,
            'cortes_pendientes' => $cortesStats->cortes_pendientes ?? 0,
            'categorias_activas' => $categoriasCount,
            'temporadas_activas' => $temporadasCount,
        ];
    }

    /**
     * Obtener estadísticas de rendimiento del sistema
     */
    public function getPerformanceStats(): array
    {
        return Cache::remember('performance_stats', self::CACHE_TTL, function () {
            return $this->calculatePerformanceStats();
        });
    }

    /**
     * Calcular estadísticas de rendimiento
     */
    private function calculatePerformanceStats(): array
    {
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
                SUM(cantidad) as total_articulos
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
    }

    /**
     * Obtener estadísticas para el dashboard
     */
    public function getDashboardStats(): array
    {
        return Cache::remember('dashboard_stats', self::CACHE_TTL, function () {
            return $this->calculateDashboardStats();
        });
    }

    /**
     * Calcular estadísticas del dashboard
     */
    private function calculateDashboardStats(): array
    {
        // Estadísticas del día actual
        $today = now()->toDateString();
        
        $cortesHoy = Corte::whereDate('fecha', $today)->count();
        $articulosNuevos = Articulo::whereDate('created_at', $today)->count();

        // Estadísticas de la semana actual
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        
        $cortesSemana = Corte::whereBetween('fecha', [$weekStart, $weekEnd])->count();
        $articulosSemana = Articulo::whereBetween('created_at', [$weekStart, $weekEnd])->count();

        // Estadísticas del mes actual
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();
        
        $cortesMes = Corte::whereBetween('fecha', [$monthStart, $monthEnd])->count();
        $articulosMes = Articulo::whereBetween('created_at', [$monthStart, $monthEnd])->count();

        return [
            'hoy' => [
                'cortes' => $cortesHoy,
                'articulos_nuevos' => $articulosNuevos,
            ],
            'semana' => [
                'cortes' => $cortesSemana,
                'articulos_nuevos' => $articulosSemana,
            ],
            'mes' => [
                'cortes' => $cortesMes,
                'articulos_nuevos' => $articulosMes,
            ],
        ];
    }

    /**
     * Limpiar caché de estadísticas
     */
    public function clearStatsCache(): void
    {
        Cache::forget('general_stats');
        Cache::forget('performance_stats');
        Cache::forget('dashboard_stats');
    }

    /**
     * Obtener estadísticas en tiempo real (sin caché)
     */
    public function getRealTimeStats(): array
    {
        return $this->calculateGeneralStats();
    }

    /**
     * Obtener estadísticas de crecimiento
     */
    public function getGrowthStats(): array
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $lastMonth = $currentMonth - 1;
        $lastYear = $currentYear;

        if ($lastMonth < 1) {
            $lastMonth = 12;
            $lastYear--;
        }

        // Artículos del mes actual vs mes anterior
        $articulosMesActual = Articulo::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $articulosMesAnterior = Articulo::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastYear)
            ->count();

        // Cortes del mes actual vs mes anterior
        $cortesMesActual = Corte::whereMonth('fecha', $currentMonth)
            ->whereYear('fecha', $currentYear)
            ->count();

        $cortesMesAnterior = Corte::whereMonth('fecha', $lastMonth)
            ->whereYear('fecha', $lastYear)
            ->count();

        return [
            'articulos' => [
                'mes_actual' => $articulosMesActual,
                'mes_anterior' => $articulosMesAnterior,
                'crecimiento' => $this->calculateGrowthRate($articulosMesActual, $articulosMesAnterior),
            ],
            'cortes' => [
                'mes_actual' => $cortesMesActual,
                'mes_anterior' => $cortesMesAnterior,
                'crecimiento' => $this->calculateGrowthRate($cortesMesActual, $cortesMesAnterior),
            ],
        ];
    }

    /**
     * Calcular tasa de crecimiento
     */
    private function calculateGrowthRate(int $current, int $previous): float
    {
        if ($previous == 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 2);
    }
}
