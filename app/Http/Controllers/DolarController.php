<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DolarController extends Controller
{
    public function index()
    {
        //hacer la consulta a la api de dolar
        $dolar = file_get_contents('https://dolarapi.com/v1/dolares');
        $dolar = json_decode($dolar, true);

        $dolarOficial = $dolar[0]['venta'];
        $dolarBlue = $dolar[1]['venta'];

        $dolarIntermedio = ($dolarOficial + $dolarBlue) / 2;

        return view('sections.dolar', compact('dolarOficial', 'dolarBlue', 'dolarIntermedio'));
    }
}
