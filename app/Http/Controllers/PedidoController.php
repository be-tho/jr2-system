<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Mostrar lista de pedidos online
     */
    public function index(Request $request)
    {
        $query = Venta::online()
            ->with(['items.articulo:id,nombre,codigo,imagen'])
            ->recent();

        // Filtros
        if ($request->has('fecha_inicio') && $request->fecha_inicio) {
            $query->where('fecha_venta', '>=', $request->fecha_inicio);
        }

        if ($request->has('fecha_fin') && $request->fecha_fin) {
            $query->where('fecha_venta', '<=', $request->fecha_fin);
        }

        if ($request->has('estado') && $request->estado) {
            $query->byEstado($request->estado);
        }

        if ($request->has('buscar') && $request->buscar) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('numero_orden', 'like', "%{$buscar}%")
                  ->orWhere('cliente_nombre', 'like', "%{$buscar}%")
                  ->orWhere('cliente_apellido', 'like', "%{$buscar}%")
                  ->orWhere('cliente_email', 'like', "%{$buscar}%");
            });
        }

        $pedidos = $query->paginate(15);

        // Estadísticas
        $estadisticas = [
            'total_pendientes' => Venta::online()->byEstado('pendiente')->count(),
            'total_procesados' => Venta::online()->byEstado('procesado')->count(),
            'total_completados' => Venta::online()->byEstado('completado')->count(),
            'total_cancelados' => Venta::online()->byEstado('cancelado')->count(),
            'total_monto' => Venta::online()->sum('total'),
        ];

        return view('sections.pedidos.index', compact('pedidos', 'estadisticas'));
    }

    /**
     * Mostrar detalle de un pedido
     */
    public function show(Venta $pedido)
    {
        // Verificar que sea un pedido online
        if (!$pedido->esOnline()) {
            abort(404);
        }

        $pedido->load(['items.articulo']);

        return view('sections.pedidos.show', compact('pedido'));
    }

    /**
     * Actualizar estado de un pedido
     */
    public function actualizarEstado(Request $request, Venta $pedido)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,procesado,completado,cancelado',
        ]);

        // Verificar que sea un pedido online
        if (!$pedido->esOnline()) {
            return redirect()->back()
                ->with('error', 'No se puede actualizar una venta manual desde esta sección');
        }

        $pedido->update([
            'estado' => $request->estado,
        ]);

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', 'Estado del pedido actualizado exitosamente');
    }

    /**
     * Actualizar notas internas de un pedido
     */
    public function actualizarNotas(Request $request, Venta $pedido)
    {
        $request->validate([
            'notas' => 'nullable|string|max:1000',
        ]);

        // Verificar que sea un pedido online
        if (!$pedido->esOnline()) {
            return redirect()->back()
                ->with('error', 'No se puede actualizar una venta manual desde esta sección');
        }

        $pedido->update([
            'notas' => $request->notas,
        ]);

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', 'Notas actualizadas exitosamente');
    }
}
