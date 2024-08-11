<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;

class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        if(empty($request->search)){
            $articulos = Articulo::all();
        }else{
            $articulos = Articulo::where('nombre', 'like', '%'.$request->query('search').'%')->get();
        }

        return view('sections.articulos', [
            'articulos' => $articulos,
            'search' => $request->query('search')
        ]);
    }
}
