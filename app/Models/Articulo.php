<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Articulo extends Model
{
    use HasFactory;

    protected $table = 'articulos';

    protected $fillable = [
        'nombre',
        'codigo',
        'temporada_id',
        'categoria_id',
        'descripcion',
        'stock',
        'precio',
        'imagen',
    ];

    protected $casts = [
        'precio' => 'integer',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con Temporada
     */
    public function temporada(): BelongsTo
    {
        return $this->belongsTo(Temporada::class, 'temporada_id');
    }

    /**
     * Relación con Categoria
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Scope para búsqueda por nombre o código
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('nombre', 'like', "%{$search}%")
              ->orWhere('codigo', 'like', "%{$search}%")
              ->orWhere('descripcion', 'like', "%{$search}%");
        });
    }

    /**
     * Scope para filtrar por categoría
     */
    public function scopeByCategoria(Builder $query, int $categoriaId): Builder
    {
        return $query->where('categoria_id', $categoriaId);
    }

    /**
     * Scope para filtrar por temporada
     */
    public function scopeByTemporada(Builder $query, int $temporadaId): Builder
    {
        return $query->where('temporada_id', $temporadaId);
    }

    /**
     * Scope para ordenar por más recientes
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope para ordenar por precio
     */
    public function scopeOrderByPrecio(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy('precio', $direction);
    }

    /**
     * Scope para ordenar por nombre
     */
    public function scopeOrderByNombre(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy('nombre', $direction);
    }

    /**
     * Obtener artículos con relaciones cargadas de forma optimizada
     */
    public static function getOptimizedList(string $search = null, int $perPage = 8)
    {
        $query = self::with(['categoria:id,nombre', 'temporada:id,nombre'])
            ->latest();

        if ($search) {
            $query->search($search);
        }

        return $query->paginate($perPage);
    }
}
