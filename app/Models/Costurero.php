<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Costurero extends Model
{
    use HasFactory;

    protected $table = 'costureros';

    protected $fillable = [
        'nombre_completo',
        'direccion',
        'celular',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope para búsqueda por nombre completo o celular
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('nombre_completo', 'like', "%{$search}%")
              ->orWhere('celular', 'like', "%{$search}%")
              ->orWhere('direccion', 'like', "%{$search}%");
        });
    }

    /**
     * Scope para ordenar por más recientes
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope para ordenar por nombre
     */
    public function scopeOrderByNombre(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy('nombre_completo', $direction);
    }

    /**
     * Obtener costureros con paginación optimizada
     */
    public static function getPaginatedList(string $search = null, int $perPage = 12)
    {
        $query = self::latest();

        if ($search) {
            $query->search($search);
        }

        return $query->paginate($perPage);
    }
}
