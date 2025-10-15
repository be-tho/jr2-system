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
     */
    protected static function boot()
    {
        parent::boot();

        // Al crear un item de venta, actualizar el stock del artículo
        static::created(function (VentaItem $ventaItem) {
            $articulo = $ventaItem->articulo;
            if ($articulo) {
                $articulo->decrement('stock', $ventaItem->cantidad);
            }
        });

        // Al eliminar un item de venta, restaurar el stock del artículo
        static::deleted(function (VentaItem $ventaItem) {
            $articulo = $ventaItem->articulo;
            if ($articulo) {
                $articulo->increment('stock', $ventaItem->cantidad);
            }
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