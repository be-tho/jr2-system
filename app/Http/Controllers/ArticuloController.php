<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticuloRequest;
use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Categoria;
use App\Models\Temporada;
use mysql_xdevapi\Exception;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        // Obtener parámetros de búsqueda y filtros
        $search = $request->get('search');
        $categoriaId = $request->get('categoria_id');
        $temporadaId = $request->get('temporada_id');
        $orderBy = $request->get('order_by', 'latest');
        $perPage = $request->get('per_page', 8);

        // Construir consulta optimizada
        $query = Articulo::with(['categoria:id,nombre', 'temporada:id,nombre']);

        // Aplicar búsqueda si existe
        if ($search) {
            $query->search($search);
        }

        // Aplicar filtros
        if ($categoriaId) {
            $query->byCategoria($categoriaId);
        }

        if ($temporadaId) {
            $query->byTemporada($temporadaId);
        }

        // Aplicar ordenamiento
        switch ($orderBy) {
            case 'precio_asc':
                $query->orderByPrecio('asc');
                break;
            case 'precio_desc':
                $query->orderByPrecio('desc');
                break;
            case 'nombre_asc':
                $query->orderByNombre('asc');
                break;
            case 'nombre_desc':
                $query->orderByNombre('desc');
                break;
            case 'stock_asc':
                $query->orderBy('stock', 'asc');
                break;
            case 'stock_desc':
                $query->orderBy('stock', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        // Ejecutar consulta con paginación
        $articulos = $query->paginate($perPage)->withQueryString();

        // Obtener categorías y temporadas para los filtros
        $categorias = Categoria::select('id', 'nombre')->orderBy('nombre')->get();
        $temporadas = Temporada::select('id', 'nombre')->orderBy('nombre')->get();

        return view('sections.articulos', [
            'articulos' => $articulos,
            'categorias' => $categorias,
            'temporadas' => $temporadas,
            'filters' => [
                'search' => $search,
                'categoria_id' => $categoriaId,
                'temporada_id' => $temporadaId,
                'order_by' => $orderBy,
                'per_page' => $perPage,
            ]
        ]);
    }

    public function show($id)
    {
        $articulo = Articulo::with(['categoria:id,nombre', 'temporada:id,nombre'])->findOrFail($id);

        return view('sections.articulos-show', [
            'articulo' => $articulo,
        ]);
    }

    public function create()
    {
        return view('sections.articulos-create');
    }

    public function store(ArticuloRequest $request)
    {
        try {
            if($request->hasFile('imagen')) {
                $manager = new ImageManager(new Driver());
                $name_img = time() . $request->file('imagen')->getClientOriginalName();
                $img = $manager->read($request->file('imagen')->getRealPath());
                $img = $img->resize(450, 600, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->toJpeg(80)->save(public_path('./src/assets/uploads/articulos/' . $name_img));

                $request->imagen = $name_img;
                $request->imagen_alt = $name_img;
            } else {
                $request->imagen = 'default-articulo.jpg';
                $request->imagen_alt = 'default-articulo.jpg';
            }

            $request->codigo = strtoupper($request->codigo);

            Articulo::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'categoria_id' => $request->categoria_id,
                'temporada_id' => $request->temporada_id,
                'imagen' => $request->imagen,
                'stock' => $request->stock,
                'codigo' => $request->codigo,
                'created_at' => now(),
            ]);
            return to_route('articulos.index')->with('success', 'Artículo creado correctamente');
        }catch (\Exception $e) {
            return to_route('articulos.index')->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id);
        return view('sections.articulos-edit-form', [
            'articulo' => $articulo,
        ]);
    }

    public function update(ArticuloRequest $request, $id)
    {
        try {
            $articulo = Articulo::findOrFail($id);
            if($request->hasFile('imagen')) {
                $manager = new ImageManager(new Driver());
                $name_img = time() . $request->file('imagen')->getClientOriginalName();
                $img = $manager->read($request->file('imagen')->getRealPath());
                //resize image hancho 450px y alto automatico

                $img = $img->resize(500, 600, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->toJpeg(80)->save(public_path('./src/assets/uploads/articulos/' . $name_img));

                $request->imagen = $name_img;
                $request->imagen_alt = $name_img;

                if($articulo->imagen != 'default-articulo.png') {
                    unlink(public_path('./src/assets/uploads/articulos/' . $articulo->imagen));
                }
            } else {
                $request->imagen = $articulo->imagen;
                $request->imagen_alt = $articulo->imagen_alt;
            }

            $request->codigo = strtoupper($request->codigo);

            $articulo->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'categoria_id' => $request->categoria_id,
                'temporada_id' => $request->temporada_id,
                'imagen' => $request->imagen,
                'stock' => $request->stock,
                'codigo' => $request->codigo,
                'updated_at' => now(),
            ]);
            return to_route('articulos.index')->with('success', 'Artículo actualizado correctamente');
        }catch (\Exception $e) {
            return to_route('articulos.index')->with('error', 'Error al actualizar el artículo');
        }
    }
}
