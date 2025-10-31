<?php

namespace App\Services;

use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OrdenService
{
    /**
     * Generar número de orden único secuencial
     * Formato: ORD-000001
     */
    public function generarNumeroOrden(): string
    {
        $lockKey = 'generar_numero_orden';
        $lockTimeout = 5; // segundos
        
        // Usar cache lock para evitar race conditions
        $lock = Cache::lock($lockKey, $lockTimeout);
        
        try {
            if ($lock->get()) {
                // Obtener el último número de orden
                $ultimaOrden = Venta::whereNotNull('numero_orden')
                    ->where('tipo', 'online')
                    ->orderBy('id', 'desc')
                    ->first();
                
                if ($ultimaOrden && $ultimaOrden->numero_orden) {
                    // Extraer el número de la última orden (ORD-000001 -> 1)
                    $ultimoNumero = (int) str_replace('ORD-', '', $ultimaOrden->numero_orden);
                    $nuevoNumero = $ultimoNumero + 1;
                } else {
                    // Primera orden
                    $nuevoNumero = 1;
                }
                
                // Formatear con ceros a la izquierda (6 dígitos)
                $numeroOrden = 'ORD-' . str_pad($nuevoNumero, 6, '0', STR_PAD_LEFT);
                
                // Verificar que no exista (por si acaso)
                $existe = Venta::where('numero_orden', $numeroOrden)->exists();
                
                if ($existe) {
                    // Si existe, intentar con el siguiente
                    $nuevoNumero++;
                    $numeroOrden = 'ORD-' . str_pad($nuevoNumero, 6, '0', STR_PAD_LEFT);
                }
                
                Log::info('Número de orden generado', ['numero_orden' => $numeroOrden]);
                
                return $numeroOrden;
            }
            
            // Si no se pudo obtener el lock, intentar de nuevo después de un breve delay
            usleep(100000); // 100ms
            return $this->generarNumeroOrden();
            
        } catch (\Exception $e) {
            Log::error('Error al generar número de orden', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        } finally {
            if (isset($lock)) {
                $lock->release();
            }
        }
    }

    /**
     * Validar que un número de orden sea válido
     */
    public function validarFormatoNumeroOrden(string $numeroOrden): bool
    {
        return preg_match('/^ORD-\d{6}$/', $numeroOrden) === 1;
    }
}

