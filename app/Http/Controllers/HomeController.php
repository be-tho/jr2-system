<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\StatsRepository;
use App\Repositories\CorteRepository;
use App\Models\Corte;

class HomeController extends Controller
{
    protected $statsRepository;
    protected $corteRepository;

    public function __construct(StatsRepository $statsRepository, CorteRepository $corteRepository)
    {
        $this->statsRepository = $statsRepository;
        $this->corteRepository = $corteRepository;
    }

    public function index()
    {
        // Obtener estadísticas del dashboard (ya con caché)
        $dashboardStats = $this->statsRepository->getDashboardStats();
        
        // Obtener estadísticas generales (ya con caché)
        $generalStats = $this->statsRepository->getGeneralStats();
        
        // Preparar variables para la vista
        $totalCortes = $generalStats['total_cortes'] ?? 0;
        $totalArticulos = $generalStats['total_articulos'] ?? 0;
        $totalCategorias = $generalStats['categorias_activas'] ?? 0;
        
        // Obtener cortes recientes (últimos 5) con campos específicos
        $cortes = $this->corteRepository->getPaginatedWithFilters([], 5);
        
        // Obtener artículos populares (con más stock) con campos específicos
        $articulosPopulares = \App\Models\Articulo::select('id', 'nombre', 'codigo', 'precio', 'stock', 'imagen')
            ->orderBy('stock', 'desc')
            ->limit(5)
            ->get();
        
        // Obtener estadísticas de rendimiento (ya con caché)
        $performanceStats = $this->statsRepository->getPerformanceStats();
        
        // Obtener estadísticas de crecimiento (ya con caché)
        $growthStats = $this->statsRepository->getGrowthStats();

        return view('sections.home', compact(
            'dashboardStats',
            'generalStats', 
            'cortes',
            'articulosPopulares',
            'performanceStats',
            'growthStats',
            'totalCortes',
            'totalArticulos',
            'totalCategorias'
        ));
    }

    /**
     * Obtener estadísticas en tiempo real (para AJAX)
     */
    public function getRealTimeStats()
    {
        $stats = $this->statsRepository->getRealTimeStats();
        
        return response()->json([
            'success' => true,
            'data' => $stats,
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * Limpiar caché de estadísticas
     */
    public function clearStatsCache()
    {
        $this->statsRepository->clearStatsCache();
        
        return response()->json([
            'success' => true,
            'message' => 'Caché de estadísticas limpiado correctamente'
        ]);
    }
}
