<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Corte;
use App\Models\Categoria;
use App\Models\Temporada;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ReporteController extends Controller
{
    public function index()
    {
        // Estadísticas generales para el dashboard
        $stats = $this->getGeneralStats();
        
        return view('sections.reportes', [
            'stats' => $stats
        ]);
    }

    public function articulos(Request $request)
    {
        $query = Articulo::with(['categoria', 'temporada']);

        // Filtros
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('temporada_id')) {
            $query->where('temporada_id', $request->temporada_id);
        }

        if ($request->filled('stock_min')) {
            $query->where('stock', '>=', $request->stock_min);
        }

        if ($request->filled('stock_max')) {
            $query->where('stock', '<=', $request->stock_max);
        }

        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }

        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }

        // Ordenamiento
        $orderBy = $request->get('order_by', 'nombre');
        $orderDirection = $request->get('order_direction', 'asc');
        $query->orderBy($orderBy, $orderDirection);

        $articulos = $query->get();

        // Estadísticas del reporte
        $reportStats = [
            'total_articulos' => $articulos->count(),
            'valor_total' => $articulos->sum('precio'),
            'stock_total' => $articulos->sum('stock'),
            'promedio_precio' => $articulos->avg('precio'),
            'articulos_sin_stock' => $articulos->where('stock', 0)->count(),
            'articulos_stock_bajo' => $articulos->where('stock', '>', 0)->where('stock', '<=', 10)->count(),
        ];

        // Agrupar por categoría
        $porCategoria = $articulos->groupBy('categoria.nombre')->map(function ($items) {
            return [
                'cantidad' => $items->count(),
                'valor_total' => $items->sum('precio'),
                'stock_total' => $items->sum('stock'),
            ];
        });

        // Agrupar por temporada
        $porTemporada = $articulos->groupBy('temporada.nombre')->map(function ($items) {
            return [
                'cantidad' => $items->count(),
                'valor_total' => $items->sum('precio'),
                'stock_total' => $items->sum('stock'),
            ];
        });



        return view('sections.reportes-articulos', [
            'articulos' => $articulos,
            'stats' => $reportStats,
            'porCategoria' => $porCategoria,
            'porTemporada' => $porTemporada,
            'categorias' => Categoria::orderBy('nombre')->get(),
            'temporadas' => Temporada::orderBy('nombre')->get(),
            'filters' => $request->all()
        ]);
    }

    public function cortes(Request $request)
    {
        $query = Corte::query();

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->fecha_hasta);
        }

        // Ordenamiento
        $orderBy = $request->get('order_by', 'fecha');
        $orderDirection = $request->get('order_direction', 'desc');
        $query->orderBy($orderBy, $orderDirection);

        $cortes = $query->get();

        // Estadísticas del reporte
        $reportStats = [
            'total_cortes' => $cortes->count(),
            'cortados' => $cortes->where('estado', 0)->count(),
            'costurando' => $cortes->where('estado', 1)->count(),
            'entregados' => $cortes->where('estado', 2)->count(),
            'total_articulos' => $cortes->sum('cantidad'),
        ];

        // Agrupar por estado
        $porEstado = $cortes->groupBy('estado')->map(function ($items, $estado) {
            $estadoNombres = ['Cortado', 'Costurando', 'Entregado'];
            return [
                'estado' => $estadoNombres[$estado] ?? 'Desconocido',
                'cantidad' => $items->count(),
                'porcentaje' => round(($items->count() / $items->count()) * 100, 1),
            ];
        });

        // Agrupar por mes
        $porMes = $cortes->groupBy(function ($item) {
            return Carbon::parse($item->fecha)->format('Y-m');
        })->map(function ($items) {
            return [
                'cantidad' => $items->count(),
                'total_articulos' => $items->sum('cantidad'),
            ];
        })->sortKeys();



        return view('sections.reportes-cortes', [
            'cortes' => $cortes,
            'stats' => $reportStats,
            'porEstado' => $porEstado,
            'porMes' => $porMes,
            'filters' => $request->all()
        ]);
    }





    private function getGeneralStats()
    {
        return [
            'total_articulos' => Articulo::count(),
            'total_cortes' => Corte::count(),
            'valor_total_inventario' => Articulo::sum(DB::raw('precio * stock')),
            'articulos_sin_stock' => Articulo::where('stock', 0)->count(),
            'cortes_pendientes' => Corte::whereIn('estado', [0, 1])->count(),
            'categorias_activas' => Categoria::count(),
            'temporadas_activas' => Temporada::count(),
        ];
    }






}
