<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corte extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'numero_corte',
        'nombre',
        'colores',
        'cantidad',
        'articulos',
        'descripcion',
        'costureros',
        'estado',
        'imagen',
        'imagen_alt',
        'created_at',
        'updated_at'
    ];
}