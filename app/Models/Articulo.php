<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'temporada_id',
        'descripcion',
        'codigo',
        'stock',
        'precio',
        'imagen',
        'categoria',
    ];

    public function temporada()
    {
        return $this->hasOne(Temporada::class, 'id', 'temporada_id');
    }

}
