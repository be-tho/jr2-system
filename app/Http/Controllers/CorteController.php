<?php

namespace App\Http\Controllers;

use App\Http\Requests\CorteRequest;
use Illuminate\Http\Request;
use App\Models\Corte;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CorteController extends Controller
{
    public function index()
    {
        // $cortes = Corte::all();
        $cortes = Corte::orderBy('id', 'desc')->get();
        return view('sections.cortes', compact('cortes'));
    }

    public function create()
    {
        return view('sections.cortes-form');
    }

    public function store(CorteRequest $request)
    {
        try {
            if($request->hasFile('imagen')) {
                $manager = new ImageManager(new Driver());
                $name_img = time() . $request->file('imagen')->getClientOriginalName();
                $img = $manager->read($request->file('imagen')->getRealPath());
                $img = $img->resize(450, 600, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->toJpeg(80)->save(public_path('./src/assets/uploads/images/cortes/' . $name_img));

                $request->imagen = $name_img;
                $request->imagen_alt = $name_img;
            } else {
                $request->imagen = 'default-corte.jpg';
                $request->imagen_alt = 'default-corte.jpg';
            }

            Corte::create([
                'numero_corte' => $request->numero_corte,
                'nombre' => $request->nombre,
                'colores' => $request->colores,
                'cantidad' => $request->cantidad,
                'articulos' => $request->articulos,
                'descripcion' => $request->descripcion,
                'costureros' => $request->costureros,
                'imagen' => $request->imagen,
                'imagen_alt' => $request->nombre,
                'fecha' => now(),
                'estado' => 0,
                'created_at' => now(),
            ]);
            return to_route('home.index')->with('success', 'Corte creado correctamente');
        }catch (\Exception $e) {
            return to_route('cortes.index')->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $corte = Corte::find($id);
        return view('sections.cortes-show', compact('corte'));
    }
}
