<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ArticuloRepository;
use App\Repositories\CorteRepository;
use App\Repositories\StatsRepository;
use App\Models\Categoria;
use App\Models\Temporada;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    protected $articuloRepository;
    protected $corteRepository;
    protected $statsRepository;

    public function __construct(
        ArticuloRepository $articuloRepository,
        CorteRepository $corteRepository,
        StatsRepository $statsRepository
    ) {
        $this->articuloRepository = $articuloRepository;
        $this->corteRepository = $corteRepository;
        $this->statsRepository = $statsRepository;
    }

    public function index()
    {
        // Obtener estadísticas generales del sistema
        $stats = $this->statsRepository->getGeneralStats();
        
        // Obtener estadísticas de rendimiento
        $performanceStats = $this->statsRepository->getPerformanceStats();
        
        return view('sections.reportes', compact('stats', 'performanceStats'));
    }

    public function articulos(Request $request)
    {
        // Preparar filtros
        $filters = [
            'categoria_id' => $request->get('categoria_id'),
            'temporada_id' => $request->get('temporada_id'),
            'stock_min' => $request->get('stock_min'),
            'stock_max' => $request->get('stock_max'),
            'precio_min' => $request->get('precio_min'),
            'precio_max' => $request->get('precio_max'),
            'order_by' => $request->get('order_by', 'nombre'),
            'order_direction' => $request->get('order_direction', 'asc'),
        ];

        // Obtener artículos con filtros aplicados
        $articulos = $this->articuloRepository->getPaginatedWithFilters($filters, 20);

        // Obtener estadísticas del reporte
        $stats = $this->articuloRepository->getStats();

        // Obtener agrupaciones
        $porCategoria = $this->articuloRepository->getGroupedByCategoria();
        $porTemporada = $this->articuloRepository->getGroupedByTemporada();

        // Obtener categorías y temporadas para filtros
        $categorias = Categoria::select('id', 'nombre')->orderBy('nombre')->get();
        $temporadas = Temporada::select('id', 'nombre')->orderBy('nombre')->get();

        return view('sections.reportes-articulos', compact(
            'articulos',
            'stats',
            'porCategoria',
            'porTemporada',
            'categorias',
            'temporadas',
            'filters'
        ));
    }

    public function cortes(Request $request)
    {
        // Preparar filtros
        $filters = [
            'estado' => $request->get('estado'),
            'fecha' => $request->get('fecha'),
            'fecha_desde' => $request->get('fecha_desde'),
            'fecha_hasta' => $request->get('fecha_hasta'),
            'order_by' => $request->get('order_by', 'fecha'),
            'order_direction' => $request->get('order_direction', 'desc'),
        ];

        // Obtener cortes con filtros aplicados
        $cortes = $this->corteRepository->getPaginatedWithFilters($filters, 20);

        // Obtener estadísticas del reporte
        $stats = $this->corteRepository->getStats();

        // Obtener agrupaciones
        $porEstado = $this->corteRepository->getGroupedByEstado();
        $porMes = $this->corteRepository->getGroupedByMes();

        return view('sections.reportes-cortes', compact(
            'cortes',
            'stats',
            'porEstado',
            'porMes',
            'filters'
        ));
    }

    /**
     * Obtener estadísticas en tiempo real para AJAX
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
     * Exportar reporte de artículos a PDF
     */
    public function exportArticulosPDF(Request $request)
    {
        try {
            // Obtener los mismos filtros que se usan en la vista
            $filters = [
                'categoria_id' => $request->get('categoria_id'),
                'temporada_id' => $request->get('temporada_id'),
                'stock_min' => $request->get('stock_min'),
                'stock_max' => $request->get('stock_max'),
                'precio_min' => $request->get('precio_min'),
                'precio_max' => $request->get('precio_max'),
                'order_by' => $request->get('order_by', 'nombre'),
                'order_direction' => $request->get('order_direction', 'asc'),
            ];

            // Obtener artículos con filtros aplicados (sin paginación para el PDF)
            $articulos = $this->articuloRepository->getPaginatedWithFilters($filters, 1000);
            $stats = $this->articuloRepository->getStats();
            $porCategoria = $this->articuloRepository->getGroupedByCategoria();
            $porTemporada = $this->articuloRepository->getGroupedByTemporada();

            // Generar el PDF
            $pdf = Pdf::loadView('pdf.reporte-articulos', compact(
                'articulos',
                'stats',
                'porCategoria',
                'porTemporada'
            ));

            // Configurar el PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'defaultFont' => 'Arial',
                'isPhpEnabled' => false,
                'isJavascriptEnabled' => false,
                'isFontSubsettingEnabled' => true,
                'debugKeepTemp' => false,
                'debugCss' => false,
                'debugLayout' => false
            ]);

            // Generar nombre del archivo
            $filename = 'reporte-articulos-' . date('Y-m-d-H-i-s') . '.pdf';

            // Configurar headers para descarga automática
            $response = response($pdf->output(), 200, [
                'Content-Type' => 'application/force-download',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Transfer-Encoding' => 'binary',
                'Content-Length' => strlen($pdf->output()),
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
                'X-Content-Type-Options' => 'nosniff'
            ]);

            // Agregar header para redirección después de la descarga
            $response->header('Refresh', '3; url=' . route('reportes.index'));
            
            return $response;
                
        } catch (\Exception $e) {
            return redirect()->route('reportes.index')
                ->with('error', 'Error al generar el reporte de artículos: ' . $e->getMessage());
        }
    }

    /**
     * Exportar reporte de cortes a PDF
     */
    public function exportCortesPDF(Request $request)
    {
        try {
            // Obtener los mismos filtros que se usan en la vista
            $filters = [
                'estado' => $request->get('estado'),
                'fecha' => $request->get('fecha'),
                'fecha_desde' => $request->get('fecha_desde'),
                'fecha_hasta' => $request->get('fecha_hasta'),
                'order_by' => $request->get('order_by', 'fecha'),
                'order_direction' => $request->get('order_direction', 'desc'),
            ];

            // Obtener cortes con filtros aplicados (sin paginación para el PDF)
            $cortes = $this->corteRepository->getPaginatedWithFilters($filters, 1000);
            $stats = $this->corteRepository->getStats();
            $porEstado = $this->corteRepository->getGroupedByEstado();
            $porMes = $this->corteRepository->getGroupedByMes();

            // Generar el PDF
            $pdf = Pdf::loadView('pdf.reporte-cortes', compact(
                'cortes',
                'stats',
                'porEstado',
                'porMes'
            ));

            // Configurar el PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'defaultFont' => 'Arial',
                'isPhpEnabled' => false,
                'isJavascriptEnabled' => false,
                'isFontSubsettingEnabled' => true,
                'debugKeepTemp' => false,
                'debugCss' => false,
                'debugLayout' => false
            ]);

            // Generar nombre del archivo
            $filename = 'reporte-cortes-' . date('Y-m-d-H-i-s') . '.pdf';

            // Configurar headers para descarga automática
            $response = response($pdf->output(), 200, [
                'Content-Type' => 'application/force-download',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Transfer-Encoding' => 'binary',
                'Content-Length' => strlen($pdf->output()),
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
                'X-Content-Type-Options' => 'nosniff'
            ]);

            // Agregar header para redirección después de la descarga
            $response->header('Refresh', '3; url=' . route('reportes.index'));
            
            return $response;
                
        } catch (\Exception $e) {
            return redirect()->route('reportes.index')
                ->with('error', 'Error al generar el reporte de cortes: ' . $e->getMessage());
        }
    }
}
