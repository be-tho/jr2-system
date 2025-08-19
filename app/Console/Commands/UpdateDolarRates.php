<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UpdateDolarRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dolar:update {--force : Force update even if cache exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update dollar exchange rates from API and cache them';

    private const API_URL = 'https://dolarapi.com/v1/dolares';
    private const CACHE_KEY = 'dolar_rates';
    private const CACHE_TTL = 300; // 5 minutos

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Actualizando tasas del dólar...');

        try {
            // Verificar si ya existe caché y no se fuerza la actualización
            if (Cache::has(self::CACHE_KEY) && !$this->option('force')) {
                $this->info('✅ Los datos del dólar ya están en caché y son recientes.');
                $this->showCachedData();
                return;
            }

            // Hacer la petición HTTP optimizada
            $response = Http::timeout(10)
                ->retry(3, 1000)
                ->get(self::API_URL);

            if (!$response->successful()) {
                throw new \Exception('Error en la API: ' . $response->status());
            }

            $dolar = $response->json();

            if (!is_array($dolar) || count($dolar) < 2) {
                throw new \Exception('Formato de respuesta inválido');
            }

            $dolarOficial = $dolar[0]['venta'] ?? 0;
            $dolarBlue = $dolar[1]['venta'] ?? 0;
            $dolarIntermedio = ($dolarOficial + $dolarBlue) / 2;

            $dolarData = [
                'dolarOficial' => $dolarOficial,
                'dolarBlue' => $dolarBlue,
                'dolarIntermedio' => $dolarIntermedio,
                'lastUpdate' => now()->format('d/m/Y H:i:s'),
                'error' => null
            ];

            // Cachear los datos
            Cache::put(self::CACHE_KEY, $dolarData, self::CACHE_TTL);

            $this->info('✅ Tasas del dólar actualizadas exitosamente!');
            $this->showCachedData();

            // Log de la actualización
            Log::info('Tasas del dólar actualizadas', $dolarData);

        } catch (\Exception $e) {
            $this->error('❌ Error al actualizar las tasas del dólar: ' . $e->getMessage());
            Log::error('Error al actualizar tasas del dólar: ' . $e->getMessage());
            
            // Mostrar datos del caché si existen
            if (Cache::has(self::CACHE_KEY)) {
                $this->warn('⚠️ Mostrando datos del caché (pueden estar desactualizados):');
                $this->showCachedData();
            }
        }
    }

    /**
     * Muestra los datos cacheados del dólar
     */
    private function showCachedData()
    {
        $data = Cache::get(self::CACHE_KEY);
        if ($data) {
            $this->table(
                ['Tipo', 'Valor', 'Última Actualización'],
                [
                    ['Oficial', '$' . number_format($data['dolarOficial'], 2), $data['lastUpdate']],
                    ['Blue', '$' . number_format($data['dolarBlue'], 2), $data['lastUpdate']],
                    ['Intermedio', '$' . number_format($data['dolarIntermedio'], 2), $data['lastUpdate']],
                ]
            );
        }
    }
}
