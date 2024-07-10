<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CorteController extends Controller
{
    public function index()
    {
        return view('sections.cortes');
    }
}
