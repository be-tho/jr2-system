<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corte extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'fecha',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the formatted created_at attribute with null safety
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y') : 'N/A';
    }

    /**
     * Get the formatted updated_at attribute with null safety
     */
    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : 'N/A';
    }
}
