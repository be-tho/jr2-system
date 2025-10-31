<?php

namespace App\Http\Controllers;

use App\Services\VentaService;
use App\Services\OrdenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    protected $ventaService;
    protected $ordenService;

    public function __construct(VentaService $ventaService, OrdenService $ordenService)
    {
        $this->ventaService = $ventaService;
        $this->ordenService = $ordenService;
    }

    /**
     * Mostrar formulario de checkout
     */
    public function index()
    {
        $carrito = session('cart', []);

        if (empty($carrito)) {
            return redirect()->route('tienda.index')
                ->with('error', 'Tu carrito está vacío');
        }

        return view('tienda.checkout');
    }

    /**
     * Procesar pedido
     */
    public function procesar(Request $request)
    {
        $request->validate([
            'cliente_nombre' => 'required|string|max:255',
            'cliente_apellido' => 'required|string|max:255',
            'cliente_email' => 'required|email|max:255',
            'cliente_telefono' => 'required|string|max:20',
            'notas' => 'nullable|string|max:1000',
        ]);

        $carrito = session('cart', []);

        if (empty($carrito)) {
            return redirect()->route('tienda.index')
                ->with('error', 'Tu carrito está vacío');
        }

        try {
            // Preparar items del carrito para el servicio
            $items = [];
            foreach ($carrito as $item) {
                $items[] = [
                    'articulo_id' => $item['articulo_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                ];
            }

            // Preparar datos del cliente
            $datosCliente = [
                'cliente_nombre' => $request->cliente_nombre,
                'cliente_apellido' => $request->cliente_apellido,
                'cliente_email' => $request->cliente_email,
                'cliente_telefono' => $request->cliente_telefono,
                'notas' => $request->notas,
            ];

            // Crear el pedido
            $venta = $this->ventaService->crearPedidoOnline(
                $datosCliente,
                $items,
                $this->ordenService
            );

            // Limpiar el carrito
            Session::forget('cart');

            // TODO: Enviar emails (Fase 2)
            // Mail::to($venta->cliente_email)->send(new OrdenConfirmacionMail($venta));
            // Mail::to(config('mail.admin_email'))->send(new NuevaOrdenAdminMail($venta));

            return redirect()->route('tienda.confirmacion', $venta->numero_orden)
                ->with('success', '¡Pedido realizado exitosamente!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al procesar el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Página de confirmación
     */
    public function confirmacion($numeroOrden)
    {
        $venta = \App\Models\Venta::where('numero_orden', $numeroOrden)
            ->with(['items.articulo'])
            ->firstOrFail();

        return view('tienda.confirmacion', compact('venta'));
    }
}
