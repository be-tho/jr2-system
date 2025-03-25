<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticuloRequest;
use Illuminate\Http\Request;
use App\Models\Articulo;
use mysql_xdevapi\Exception;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        if(empty($request->search)){
            //traer todos los articulos paginados
            $articulos = Articulo::orderBy('id', 'desc')->paginate(8);
        }else{
            $articulos = Articulo::where('nombre', 'like', '%'.$request->query('search').'%')->get();
        }

        return view('sections.articulos', [
            'articulos' => $articulos,
            'search' => $request->query('search')
        ]);
    }

    public function show($id)
    {
        $articulo = Articulo::with(['categoria', 'temporada'])->findOrFail($id);
        $articulo['categoria'] = $articulo['categoria']['nombre'];
        $articulo['temporada'] = $articulo['temporada']['nombre'];

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
