<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VentaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'articulo_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'detalle',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con la venta
     */
    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    /**
     * Relación con el artículo
     */
    public function articulo(): BelongsTo
    {
        return $this->belongsTo(Articulo::class);
    }

    /**
     * Boot del modelo para eventos
     * NOTA: La lógica de stock ahora se maneja en VentaService para mayor control y consistencia
     */
    protected static function boot()
    {
        parent::boot();

        // Logging para auditoría (opcional)
        static::created(function (VentaItem $ventaItem) {
            \Log::info('VentaItem creado', [
                'venta_item_id' => $ventaItem->id,
                'venta_id' => $ventaItem->venta_id,
                'articulo_id' => $ventaItem->articulo_id,
                'cantidad' => $ventaItem->cantidad,
                'subtotal' => $ventaItem->subtotal
            ]);
        });

        static::deleted(function (VentaItem $ventaItem) {
            \Log::info('VentaItem eliminado', [
                'venta_item_id' => $ventaItem->id,
                'venta_id' => $ventaItem->venta_id,
                'articulo_id' => $ventaItem->articulo_id,
                'cantidad' => $ventaItem->cantidad,
                'subtotal' => $ventaItem->subtotal
            ]);
        });
    }

    /**
     * Calcular el subtotal automáticamente
     */
    public function calcularSubtotal(): float
    {
        return $this->cantidad * $this->precio_unitario;
    }

    /**
     * Obtener el precio unitario formateado
     */
    public function getPrecioUnitarioFormateadoAttribute(): string
    {
        return '$' . number_format($this->precio_unitario, 2, '.', ',');
    }

    /**
     * Obtener el subtotal formateado
     */
    public function getSubtotalFormateadoAttribute(): string
    {
        return '$' . number_format($this->subtotal, 2, '.', ',');
    }

    /**
     * Obtener el detalle del artículo o usar el nombre por defecto
     */
    public function getDetalleCompletoAttribute(): string
    {
        return $this->detalle ?: $this->articulo->nombre;
    }
}