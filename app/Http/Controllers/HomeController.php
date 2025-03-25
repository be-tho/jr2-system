<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Corte;

class HomeController extends Controller

{
    public function index()
    {
        $cortes = Corte::all();
        return view('sections.home', compact('cortes'));
    }
}
