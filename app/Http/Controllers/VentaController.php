<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\VentaItem;
use App\Models\Articulo;
use App\Http\Requests\StoreVentaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filtros = [
            'fecha_inicio' => $request->get('fecha_inicio'),
            'fecha_fin' => $request->get('fecha_fin'),
            'cliente' => $request->get('cliente'),
            'articulo_id' => $request->get('articulo_id'),
        ];

        $ventas = Venta::getOptimizedList($filtros);
        
        // Para el filtro de artículos
        $articulos = Articulo::select('id', 'nombre', 'codigo')->orderBy('nombre')->get();

        return view('sections.ventas.index', compact('ventas', 'articulos', 'filtros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sections.ventas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVentaRequest $request)
    {
        try {
            DB::beginTransaction();

            // Calcular el total de la venta
            $total = 0;
            foreach ($request->items as $item) {
                $subtotal = $item['cantidad'] * $item['precio_unitario'];
                $total += $subtotal;
            }

            // Crear la venta
            $venta = Venta::create([
                'user_id' => Auth::id(),
                'cliente_nombre' => $request->cliente_nombre,
                'total' => $total,
                'fecha_venta' => now(),
                'notas' => $request->notas,
            ]);

            // Crear los items de la venta
            foreach ($request->items as $item) {
                $subtotal = $item['cantidad'] * $item['precio_unitario'];
                
                VentaItem::create([
                    'venta_id' => $venta->id,
                    'articulo_id' => $item['articulo_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $subtotal,
                    'detalle' => $item['detalle'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('ventas.show', $venta)
                ->with('success', 'Venta registrada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al registrar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        $venta->load(['user', 'items.articulo']);
        
        return view('sections.ventas.show', compact('venta'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        try {
            DB::beginTransaction();

            // Eliminar la venta (los items se eliminarán automáticamente por cascade)
            // y el stock se restaurará automáticamente por el evento del modelo VentaItem
            $venta->delete();

            DB::commit();

            return redirect()->route('ventas.index')
                ->with('success', 'Venta eliminada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Búsqueda AJAX de artículos para el autocompletado
     */
    public function searchArticulos(Request $request)
    {
        $search = $request->get('q', '');
        
        $query = Articulo::select('id', 'nombre', 'codigo', 'precio', 'stock', 'imagen', 'descripcion')
            ->where('stock', '>', 0); // Solo artículos con stock disponible

        // Si hay búsqueda, aplicar filtros
        if (strlen($search) >= 1) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            })
            ->orderByRaw("
                CASE 
                    WHEN nombre LIKE ? THEN 1
                    WHEN codigo LIKE ? THEN 2
                    WHEN descripcion LIKE ? THEN 3
                    ELSE 4
                END
            ", ["{$search}%", "{$search}%", "{$search}%"])
            ->limit(15); // Límite para búsquedas específicas
        } else {
            // Si no hay búsqueda, devolver todos los artículos disponibles
            $query->orderBy('nombre')
                  ->limit(50); // Límite más alto para la lista completa
        }

        $articulos = $query->get();

        return response()->json($articulos->map(function ($articulo) {
            return [
                'id' => $articulo->id,
                'nombre' => $articulo->nombre,
                'codigo' => $articulo->codigo,
                'precio' => $articulo->precio,
                'stock' => $articulo->stock,
                'imagen' => $articulo->getMainImage(),
                'descripcion' => $articulo->descripcion,
                'precio_formateado' => '$' . number_format($articulo->precio, 2, '.', ','),
                'stock_disponible' => $articulo->stock > 0,
            ];
        }));
    }

    /**
     * Obtener estadísticas de ventas para el dashboard
     */
    public function getEstadisticas(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');

        $estadisticas = Venta::getEstadisticas($fechaInicio, $fechaFin);

        return response()->json([
            'total_ventas' => $estadisticas['total_ventas'],
            'total_monto' => number_format($estadisticas['total_monto'], 2, '.', ','),
            'promedio_venta' => number_format($estadisticas['promedio_venta'], 2, '.', ','),
        ]);
    }

    /**
     * Mostrar vista de impresión de una venta
     */
    public function print(Venta $venta)
    {
        // Cargar relaciones necesarias
        $venta->load(['items.articulo', 'user']);

        // Datos de la empresa (puedes configurar estos valores)
        $companyData = [
            'company_name' => 'JR2 System',
            'company_address' => 'Cuenca 218, Flores',
            'company_phone' => 'Teléfono: (11) 3092-2950',
            'company_email' => 'yiyevp@gmail.com',
            'company_logo' => null, // Puedes agregar la ruta del logo aquí
        ];

        // Datos del documento
        $documentData = [
            'document_title' => 'COMPROBANTE DE VENTA',
            'document_number' => 'VTA-' . str_pad($venta->id, 6, '0', STR_PAD_LEFT),
            'document_date' => $venta->created_at->format('d/m/Y'),
            'document_time' => $venta->created_at->format('H:i'),
        ];

        return view('pdf.venta', array_merge([
            'venta' => $venta,
        ], $companyData, $documentData));
    }
}