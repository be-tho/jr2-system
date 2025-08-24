<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categoria';

    protected $fillable = [
        'id',
        'nombre',
    ];

    /**
     * Obtener los artículos de esta categoría
     */
    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'categoria_id');
    }

    /**
     * Obtener el conteo de artículos con eager loading
     */
    public function scopeWithArticulosCount($query)
    {
        return $query->withCount('articulos');
    }

    /**
     * Get the formatted created_at attribute with null safety
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y H:i') : 'N/A';
    }

    /**
     * Get the formatted updated_at attribute with null safety
     */
    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : 'N/A';
    }
}
