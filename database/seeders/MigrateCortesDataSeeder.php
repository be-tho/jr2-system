<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class MigrateCortesDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->logInfo('Iniciando migración de datos de cortes...');

        // Verificar si la tabla existe
        if (!Schema::hasTable('cortes')) {
            $this->logError('La tabla cortes no existe.');
            return;
        }

        // Verificar si ya se ejecutó la migración
        if (Schema::hasColumn('cortes', 'tipo_tela')) {
            $this->logInfo('La migración de cortes ya se ejecutó anteriormente.');
            return;
        }

        $this->logInfo('Migrando datos de cortes...');

        try {
            // Obtener todos los cortes existentes
            $cortes = DB::table('cortes')->get();
            $this->logInfo("Encontrados {$cortes->count()} cortes para migrar.");

            $migratedCount = 0;
            foreach ($cortes as $corte) {
                // Migrar datos a la nueva estructura
                $updateData = [
                    'tipo_tela' => 'Tela estándar', // Valor por defecto
                    'cantidad_encimadas' => $corte->cantidad ?? 1, // Usar cantidad como encimadas por defecto
                    'colores' => json_encode($this->parseColores($corte->colores ?? '')),
                    'cantidad_total' => $corte->cantidad ?? 0,
                    'descripcion' => $corte->nombre ?? 'Sin descripción',
                    'imagen_alt' => $corte->imagen_alt ?? $corte->imagen ?? 'default-corte.svg',
                ];

                DB::table('cortes')
                    ->where('id', $corte->id)
                    ->update($updateData);
                
                $migratedCount++;
            }

            $this->logInfo("Migración completada. {$migratedCount} cortes migrados exitosamente.");

        } catch (\Exception $e) {
            $this->logError('Error durante la migración: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Parsear colores del string a formato JSON
     */
    private function parseColores(string $coloresString): array
    {
        if (empty($coloresString)) {
            return [];
        }

        // Intentar parsear diferentes formatos de colores
        $colores = [];

        // Si ya es un JSON válido, devolverlo
        if ($this->isValidJson($coloresString)) {
            $parsedColors = json_decode($coloresString, true) ?? [];
            
            // Convertir formato anterior (objeto) a nuevo formato (array de objetos)
            if (is_array($parsedColors) && !empty($parsedColors)) {
                // Si es un objeto simple (formato anterior), convertirlo a array de objetos
                if (array_keys($parsedColors) !== range(0, count($parsedColors) - 1)) {
                    $newColors = [];
                    foreach ($parsedColors as $color => $cantidad) {
                        $newColors[] = [
                            'color' => $color,
                            'cantidad' => $cantidad
                        ];
                    }
                    return $newColors;
                }
                // Si ya es un array de objetos, devolverlo tal como está
                return $parsedColors;
            }
            
            return [];
        }

        // Parsear formato "color: cantidad, color2: cantidad2"
        if (strpos($coloresString, ':') !== false) {
            $pairs = explode(',', $coloresString);
            foreach ($pairs as $pair) {
                $parts = explode(':', trim($pair));
                if (count($parts) === 2) {
                    $color = trim($parts[0]);
                    $cantidad = (int) trim($parts[1]);
                    if ($color && $cantidad > 0) {
                        $colores[] = [
                            'color' => $color,
                            'cantidad' => $cantidad
                        ];
                    }
                }
            }
        } else {
            // Si es solo una lista de colores, asignar cantidad 1 a cada uno
            $coloresList = explode(',', $coloresString);
            foreach ($coloresList as $color) {
                $color = trim($color);
                if ($color) {
                    $colores[] = [
                        'color' => $color,
                        'cantidad' => 1
                    ];
                }
            }
        }

        return $colores;
    }

    /**
     * Verificar si un string es JSON válido
     */
    private function isValidJson(string $string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Log info message
     */
    private function logInfo(string $message): void
    {
        if ($this->command) {
            $this->command->info($message);
        }
        Log::info($message);
    }

    /**
     * Log error message
     */
    private function logError(string $message): void
    {
        if ($this->command) {
            $this->command->error($message);
        }
        Log::error($message);
    }
}
