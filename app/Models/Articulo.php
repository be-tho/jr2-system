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
        'categoria_id',
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
    public function categoria()
    {
        return $this->hasOne(Categoria::class, 'id', 'categoria_id');
    }

}
