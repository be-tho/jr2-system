<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Categoria;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    /**
     * Mostrar catálogo de productos
     */
    public function index(Request $request)
    {
        $query = Articulo::with(['categoria:id,nombre'])
            ->where('stock', '>', 0); // Solo productos con stock disponible

        // Filtros
        if ($request->has('buscar') && $request->buscar) {
            $query->search($request->buscar);
        }

        if ($request->has('categoria_id') && $request->categoria_id) {
            $query->byCategoria($request->categoria_id);
        }

        if ($request->has('temporada_id') && $request->temporada_id) {
            $query->byTemporada($request->temporada_id);
        }

        // Ordenamiento
        $orden = $request->get('orden', 'recientes');
        switch ($orden) {
            case 'precio_asc':
                $query->orderByPrecio('asc');
                break;
            case 'precio_desc':
                $query->orderByPrecio('desc');
                break;
            case 'nombre':
                $query->orderByNombre('asc');
                break;
            default:
                $query->latest();
        }

        $articulos = $query->paginate(12);
        
        // Obtener categorías y temporadas para filtros
        $categorias = Categoria::orderBy('nombre')
            ->get(['id', 'nombre']);
        
        $temporadas = \App\Models\Temporada::orderBy('nombre')
            ->get(['id', 'nombre']);

        return view('tienda.index', compact('articulos', 'categorias', 'temporadas'));
    }

    /**
     * Mostrar detalle de un producto
     */
    public function show(Articulo $articulo)
    {
        // Cargar relaciones
        $articulo->load(['categoria:id,nombre', 'temporada:id,nombre']);
        
        // Obtener productos relacionados (misma categoría)
        $productosRelacionados = Articulo::where('categoria_id', $articulo->categoria_id)
            ->where('id', '!=', $articulo->id)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();

        return view('tienda.show', compact('articulo', 'productosRelacionados'));
    }
}
