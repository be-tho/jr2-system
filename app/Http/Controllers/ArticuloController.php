<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;

class ArticuloController extends Controller
{
    public function index()
    {
        //mandar a la vista todos los articulos

        $articulos = Articulo::all();
        return view('sections.articulos', compact('articulos'));
    }
}
