<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CarritoController extends Controller
{
    /**
     * Obtener el carrito actual
     */
    public function index(): JsonResponse
    {
        $carrito = session('cart', []);
        $items = [];
        $total = 0;

        foreach ($carrito as $item) {
            $articulo = Articulo::find($item['articulo_id']);
            if ($articulo && $articulo->stock > 0) {
                $precioEfectivo = $articulo->getPrecioEfectivo();
                $subtotal = $item['cantidad'] * $precioEfectivo;
                $total += $subtotal;

                $items[] = [
                    'articulo_id' => $articulo->id,
                    'nombre' => $articulo->nombre,
                    'codigo' => $articulo->codigo,
                    'imagen' => \App\Helpers\ImageHelper::getArticuloImageUrl($articulo->getMainImage()),
                    'precio_unitario' => $precioEfectivo,
                    'precio_formateado' => '$' . number_format($precioEfectivo, 2, '.', ','),
                    'cantidad' => $item['cantidad'],
                    'stock_disponible' => $articulo->stock,
                    'subtotal' => $subtotal,
                    'subtotal_formateado' => '$' . number_format($subtotal, 2, '.', ','),
                ];
            }
        }

        return response()->json([
            'items' => $items,
            'total' => $total,
            'total_formateado' => '$' . number_format($total, 2, '.', ','),
            'cantidad_items' => count($items),
        ]);
    }

    /**
     * Agregar producto al carrito
     */
    public function agregar(Request $request): JsonResponse
    {
        $request->validate([
            'articulo_id' => 'required|exists:articulos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $articulo = Articulo::findOrFail($request->articulo_id);

        // Validar stock
        if ($articulo->stock < $request->cantidad) {
            return response()->json([
                'success' => false,
                'message' => 'Stock insuficiente. Disponible: ' . $articulo->stock,
            ], 400);
        }

        $carrito = session('cart', []);
        $precioEfectivo = $articulo->getPrecioEfectivo();
        
        // Buscar si el artículo ya está en el carrito
        $index = collect($carrito)->search(function ($item) use ($request) {
            return $item['articulo_id'] == $request->articulo_id;
        });

        if ($index !== false) {
            // Actualizar cantidad
            $nuevaCantidad = $carrito[$index]['cantidad'] + $request->cantidad;
            
            // Validar stock total
            if ($articulo->stock < $nuevaCantidad) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock insuficiente. Disponible: ' . $articulo->stock,
                ], 400);
            }
            
            $carrito[$index]['cantidad'] = $nuevaCantidad;
        } else {
            // Agregar nuevo item
            $carrito[] = [
                'articulo_id' => $request->articulo_id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $precioEfectivo,
            ];
        }

        session(['cart' => $carrito]);

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'cart_count' => count($carrito),
        ]);
    }

    /**
     * Actualizar cantidad de un producto en el carrito
     */
    public function actualizar(Request $request): JsonResponse
    {
        $request->validate([
            'articulo_id' => 'required|exists:articulos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $articulo = Articulo::findOrFail($request->articulo_id);

        // Validar stock
        if ($articulo->stock < $request->cantidad) {
            return response()->json([
                'success' => false,
                'message' => 'Stock insuficiente. Disponible: ' . $articulo->stock,
            ], 400);
        }

        $carrito = session('cart', []);
        
        $index = collect($carrito)->search(function ($item) use ($request) {
            return $item['articulo_id'] == $request->articulo_id;
        });

        if ($index === false) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado en el carrito',
            ], 404);
        }

        $carrito[$index]['cantidad'] = $request->cantidad;
        session(['cart' => $carrito]);

        return response()->json([
            'success' => true,
            'message' => 'Carrito actualizado',
        ]);
    }

    /**
     * Eliminar producto del carrito
     */
    public function eliminar(Request $request): JsonResponse
    {
        $request->validate([
            'articulo_id' => 'required|exists:articulos,id',
        ]);

        $carrito = session('cart', []);
        
        $carrito = array_filter($carrito, function ($item) use ($request) {
            return $item['articulo_id'] != $request->articulo_id;
        });

        // Reindexar array
        $carrito = array_values($carrito);
        
        session(['cart' => $carrito]);

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado del carrito',
            'cart_count' => count($carrito),
        ]);
    }

    /**
     * Limpiar el carrito
     */
    public function limpiar(): JsonResponse
    {
        session(['cart' => []]);

        return response()->json([
            'success' => true,
            'message' => 'Carrito limpiado',
        ]);
    }

    /**
     * Obtener cantidad de items en el carrito
     */
    public function cantidad(): JsonResponse
    {
        $carrito = session('cart', []);
        $cantidad = 0;

        foreach ($carrito as $item) {
            $cantidad += $item['cantidad'];
        }

        return response()->json([
            'cantidad' => $cantidad,
            'items' => count($carrito),
        ]);
    }
}
