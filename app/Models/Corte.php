<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corte extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_corte',
        'tipo_tela',
        'colores',
        'cantidad_total',
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

    protected $casts = [
        'colores' => 'array',
        'fecha' => 'date',
        'estado' => 'integer',
        'cantidad_total' => 'integer',
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

    /**
     * Get the formatted fecha attribute
     */
    public function getFormattedFechaAttribute()
    {
        return $this->fecha ? $this->fecha->format('d/m/Y') : 'N/A';
    }

    /**
     * Get the estado name
     */
    public function getEstadoNombreAttribute()
    {
        $estados = [
            0 => 'Cortado',
            1 => 'Costurando',
            2 => 'Entregado'
        ];
        
        return $estados[$this->estado] ?? 'Desconocido';
    }

    /**
     * Get the total quantity from colors JSON
     */
    public function getCantidadTotalColoresAttribute()
    {
        if (!$this->colores) {
            return 0;
        }
        
        $total = 0;
        foreach ($this->colores as $colorData) {
            if (is_array($colorData) && isset($colorData['cantidad'])) {
                $total += $colorData['cantidad'];
            } elseif (is_numeric($colorData)) {
                // Compatibilidad con formato anterior
                $total += $colorData;
            }
        }
        
        return $total;
    }

    /**
     * Get colors as formatted string
     */
    public function getColoresFormateadosAttribute()
    {
        if (!$this->colores) {
            return 'Sin colores';
        }
        
        $coloresFormateados = [];
        foreach ($this->colores as $colorData) {
            if (is_array($colorData) && isset($colorData['color']) && isset($colorData['cantidad'])) {
                $coloresFormateados[] = ucfirst($colorData['color']) . ': ' . $colorData['cantidad'];
            } elseif (is_string($colorData)) {
                // Compatibilidad con formato anterior
                $coloresFormateados[] = ucfirst($colorData);
            }
        }
        
        return implode(', ', $coloresFormateados);
    }

    /**
     * Get colors as simple array for backward compatibility
     */
    public function getColoresSimplesAttribute()
    {
        if (!$this->colores) {
            return [];
        }
        
        $coloresSimples = [];
        foreach ($this->colores as $colorData) {
            if (is_array($colorData) && isset($colorData['color']) && isset($colorData['cantidad'])) {
                $color = $colorData['color'];
                $cantidad = $colorData['cantidad'];
                
                if (isset($coloresSimples[$color])) {
                    $coloresSimples[$color] += $cantidad;
                } else {
                    $coloresSimples[$color] = $cantidad;
                }
            }
        }
        
        return $coloresSimples;
    }

    /**
     * Set colors from array
     */
    public function setColoresAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['colores'] = json_encode($value);
        } else {
            $this->attributes['colores'] = json_encode($value);
        }
    }

    /**
     * Get colors as array
     */
    public function getColoresAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }
}
