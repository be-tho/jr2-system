<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $corte = new Corte();
        $corte->fecha = $request->fecha;
        $corte->hora = $request->hora;
        $corte->save();
        return redirect()->route('cortes.index');
    }

    public function show($id)
    {
        $corte = Corte::find($id);
        return view('sections.cortes', compact('corte'));
    }
}
