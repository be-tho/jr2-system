<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cliente_nombre',
        'total',
        'fecha_venta',
        'notas',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'fecha_venta' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con el usuario que registró la venta
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con los items de la venta
     */
    public function items(): HasMany
    {
        return $this->hasMany(VentaItem::class);
    }

    /**
     * Scope para filtrar por fecha
     */
    public function scopeByFecha(Builder $query, $fechaInicio = null, $fechaFin = null): Builder
    {
        if ($fechaInicio) {
            $query->where('fecha_venta', '>=', $fechaInicio);
        }
        
        if ($fechaFin) {
            $query->where('fecha_venta', '<=', $fechaFin);
        }
        
        return $query;
    }

    /**
     * Scope para filtrar por cliente
     */
    public function scopeByCliente(Builder $query, string $cliente): Builder
    {
        return $query->where('cliente_nombre', 'like', "%{$cliente}%");
    }

    /**
     * Scope para ordenar por más recientes
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('fecha_venta', 'desc');
    }

    /**
     * Scope para filtrar por artículo
     */
    public function scopeByArticulo(Builder $query, int $articuloId): Builder
    {
        return $query->whereHas('items', function (Builder $q) use ($articuloId) {
            $q->where('articulo_id', $articuloId);
        });
    }

    /**
     * Calcular el total de la venta sumando todos los items
     */
    public function calcularTotal(): float
    {
        return $this->items()->sum('subtotal');
    }

    /**
     * Obtener el total formateado
     */
    public function getTotalFormateadoAttribute(): string
    {
        return '$' . number_format($this->total, 2, '.', ',');
    }

    /**
     * Obtener la fecha de venta formateada
     */
    public function getFechaVentaFormateadaAttribute(): string
    {
        return $this->fecha_venta->format('d/m/Y H:i');
    }

    /**
     * Obtener ventas con relaciones cargadas de forma optimizada
     */
    public static function getOptimizedList(array $filtros = [], int $perPage = 15)
    {
        $query = self::with(['user:id,name', 'items.articulo:id,nombre,codigo'])
            ->recent();

        // Aplicar filtros
        if (!empty($filtros['fecha_inicio']) || !empty($filtros['fecha_fin'])) {
            $query->byFecha($filtros['fecha_inicio'] ?? null, $filtros['fecha_fin'] ?? null);
        }

        if (!empty($filtros['cliente'])) {
            $query->byCliente($filtros['cliente']);
        }

        if (!empty($filtros['articulo_id'])) {
            $query->byArticulo($filtros['articulo_id']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Obtener estadísticas de ventas
     */
    public static function getEstadisticas($fechaInicio = null, $fechaFin = null)
    {
        $query = self::query();
        
        if ($fechaInicio) {
            $query->where('fecha_venta', '>=', $fechaInicio);
        }
        
        if ($fechaFin) {
            $query->where('fecha_venta', '<=', $fechaFin);
        }

        return [
            'total_ventas' => $query->count(),
            'total_monto' => $query->sum('total'),
            'promedio_venta' => $query->avg('total'),
        ];
    }
}