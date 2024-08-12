<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Articulo extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'temporada_id',
        'categoria_id',
        'descripcion',
        'codigo',
        'stock',
        'precio',
        'imagen',
    ];

    public function temporada(): HasOne
    {
        return $this->hasOne(Temporada::class, 'id', 'temporada_id');
    }
    public function categoria(): HasOne
    {
        return $this->hasOne(Categoria::class, 'id', 'categoria_id');
    }

}
