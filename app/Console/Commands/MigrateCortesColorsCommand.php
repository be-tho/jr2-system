<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MigrateCortesColorsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortes:migrate-colors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrar colores de cortes al nuevo formato de array de objetos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando migración de colores de cortes...');
        
        try {
            // Obtener todos los cortes existentes
            $cortes = DB::table('cortes')->get();
            $this->info("Encontrados {$cortes->count()} cortes para migrar colores.");

            $migratedCount = 0;
            foreach ($cortes as $corte) {
                $oldColors = $corte->colores;
                
                if ($oldColors) {
                    $newColors = $this->convertColorsToNewFormat($oldColors);
                    
                    if ($newColors !== null) {
                        DB::table('cortes')
                            ->where('id', $corte->id)
                            ->update(['colores' => json_encode($newColors)]);
                        
                        $migratedCount++;
                        $this->line("Corte ID {$corte->id}: Colores migrados correctamente");
                    }
                }
            }

            $this->info("Migración completada. {$migratedCount} cortes migrados exitosamente.");

        } catch (\Exception $e) {
            $this->error('Error durante la migración: ' . $e->getMessage());
            Log::error('Error en migración de colores: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Convertir colores al nuevo formato
     */
    private function convertColorsToNewFormat($oldColors): ?array
    {
        if (empty($oldColors)) {
            return [];
        }

        // Si ya es un JSON válido
        if (is_string($oldColors) && $this->isValidJson($oldColors)) {
            $parsedColors = json_decode($oldColors, true) ?? [];
            
            // Si ya está en el nuevo formato (array de objetos), devolverlo tal como está
            if (is_array($parsedColors) && !empty($parsedColors)) {
                if (array_keys($parsedColors) === range(0, count($parsedColors) - 1)) {
                    // Ya es un array de objetos
                    return $parsedColors;
                } else {
                    // Es un objeto simple, convertirlo a array de objetos
                    $newColors = [];
                    foreach ($parsedColors as $color => $cantidad) {
                        $newColors[] = [
                            'color' => $color,
                            'cantidad' => $cantidad
                        ];
                    }
                    return $newColors;
                }
            }
        }

        // Si es un string simple, intentar parsearlo
        if (is_string($oldColors)) {
            return $this->parseColorsString($oldColors);
        }

        return null;
    }

    /**
     * Parsear string de colores
     */
    private function parseColorsString(string $colorsString): array
    {
        $colores = [];

        // Parsear formato "color: cantidad, color2: cantidad2"
        if (strpos($colorsString, ':') !== false) {
            $pairs = explode(',', $colorsString);
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
            $coloresList = explode(',', $colorsString);
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
}
