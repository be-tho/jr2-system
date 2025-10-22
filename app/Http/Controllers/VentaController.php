<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\VentaItem;
use App\Models\Articulo;
use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Services\VentaService;
use App\Services\ArticuloService;
use App\Exceptions\InsufficientStockException;
use App\Exceptions\VentaException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    protected $ventaService;
    protected $articuloService;

    public function __construct(VentaService $ventaService, ArticuloService $articuloService)
    {
        $this->ventaService = $ventaService;
        $this->articuloService = $articuloService;
    }

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

        $ventas = $this->ventaService->getVentasConFiltros($filtros);
        
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
            $datosVenta = [
                'cliente_nombre' => $request->cliente_nombre,
                'notas' => $request->notas,
            ];

            $venta = $this->ventaService->crearVenta($datosVenta, $request->items);

            return redirect()->route('ventas.show', $venta)
                ->with('success', 'Venta registrada exitosamente.');

        } catch (InsufficientStockException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
                
        } catch (VentaException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
                
        } catch (\Exception $e) {
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
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        $venta->load(['items.articulo']);
        
        // Preparar datos de la venta original
        $ventaOriginal = $venta->items->map(function($item) {
            return [
                'id' => (int) $item->articulo->id,
                'nombre' => $item->articulo->nombre,
                'codigo' => $item->articulo->codigo,
                'precio' => (float) $item->precio_unitario,
                'stock' => (int) ($item->articulo->stock + $item->cantidad),
                'imagen' => $item->articulo->imagen,
                'cantidad' => (int) $item->cantidad,
                'subtotal' => (float) $item->subtotal,
                'detalle' => $item->detalle
            ];
        });
        
        return view('sections.ventas.edit', compact('venta', 'ventaOriginal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVentaRequest $request, Venta $venta)
    {
        try {
            $datosVenta = [
                'cliente_nombre' => $request->cliente_nombre,
                'notas' => $request->notas,
            ];

            $ventaActualizada = $this->ventaService->actualizarVenta($venta->id, $datosVenta, $request->items);

            return redirect()->route('ventas.show', $ventaActualizada)
                ->with('success', 'Venta actualizada exitosamente.');

        } catch (InsufficientStockException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
                
        } catch (VentaException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        try {
            $this->ventaService->eliminarVenta($venta->id);

            return redirect()->route('ventas.index')
                ->with('success', 'Venta eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Búsqueda AJAX de artículos para el autocompletado
     */
    public function searchArticulos(Request $request)
    {
        $search = $request->get('q', '') ?: '';
        $usarPrecioPromocion = $request->get('usar_precio_promocion', false);
        
        $articulos = $this->articuloService->getArticulosDisponiblesParaVenta($search);

        return response()->json($articulos->map(function ($articulo) use ($usarPrecioPromocion) {
            $precioEfectivo = $usarPrecioPromocion && $articulo->hasPrecioPromocion() 
                ? (float) $articulo->precio_promocion 
                : (float) $articulo->precio;
                
            return [
                'id' => $articulo->id,
                'nombre' => $articulo->nombre,
                'codigo' => $articulo->codigo,
                'precio' => $precioEfectivo,
                'precio_original' => (float) $articulo->precio,
                'precio_promocion' => $articulo->precio_promocion ? (float) $articulo->precio_promocion : null,
                'tiene_precio_promocion' => $articulo->hasPrecioPromocion(),
                'stock' => (int) $articulo->stock,
                'imagen' => $articulo->getMainImage(),
                'descripcion' => $articulo->descripcion,
                'precio_formateado' => '$' . number_format($precioEfectivo, 2, '.', ','),
                'precio_original_formateado' => '$' . number_format($articulo->precio, 2, '.', ','),
                'precio_promocion_formateado' => $articulo->hasPrecioPromocion() ? '$' . number_format($articulo->precio_promocion, 2, '.', ',') : null,
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

        $estadisticas = $this->ventaService->getEstadisticasVentas($fechaInicio, $fechaFin);

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
        $venta->load(['items.articulo', 'user']);

        return view('pdf.venta', [
            'venta' => $venta,
            'company_name' => 'JR2 System',
            'company_address' => 'Cuenca 218, Flores',
            'company_phone' => 'Teléfono: (11) 3092-2950',
            'company_email' => 'yiyevp@gmail.com',
            'company_logo' => null,
            'document_title' => 'COMPROBANTE DE VENTA',
            'document_number' => 'VTA-' . str_pad($venta->id, 6, '0', STR_PAD_LEFT),
            'document_date' => $venta->created_at->format('d/m/Y'),
            'document_time' => $venta->created_at->format('H:i'),
        ]);
    }
}