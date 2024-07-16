<?php

namespace App\Http\Controllers;

use App\Http\Requests\CorteRequest;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Corte;

class CorteController extends Controller
{
    public function index()
    {
        return view('sections.cortes');
    }

    public function create()
    {
        return view('sections.cortes-form');
    }

    public function store(CorteRequest $request)
    {
        try {
            if($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombre_imagen = time() . '.' . $imagen->getClientOriginalName();
                $ruta_imagen = public_path().'/uploads/images/cortes/'.$nombre_imagen;
                Image::make($imagen->getRealPath())
                    ->resize(450, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($ruta_imagen);
                $request->imagen = $nombre_imagen;
                $request->imagen_alt = $nombre_imagen;
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
            return to_route('home.index')->with('error', 'Error al crear el corte', $e->getMessage());
        }
    }

    public function show($id)
    {
        $corte = Corte::find($id);
        return view('sections.cortes', compact('corte'));
    }
}
