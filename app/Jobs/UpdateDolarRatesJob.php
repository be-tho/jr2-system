<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UpdateDolarRatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 30;
    public $tries = 3;
    public $backoff = [5, 10, 15]; // Esperar 5, 10, 15 segundos entre reintentos

    private const API_URL = 'https://dolarapi.com/v1/dolares';
    private const CACHE_KEY = 'dolar_rates';
    private const CACHE_TTL = 300; // 5 minutos

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('🔄 Iniciando actualización de tasas del dólar...');

            // Hacer la petición HTTP optimizada con timeout y retry
            $response = Http::timeout(15)
                ->retry(2, 2000)
                ->withHeaders([
                    'User-Agent' => 'Laravel-App/1.0',
                    'Accept' => 'application/json'
                ])
                ->get(self::API_URL);

            if (!$response->successful()) {
                throw new \Exception('Error en la API del dólar: ' . $response->status());
            }

            $dolar = $response->json();

            if (!is_array($dolar) || count($dolar) < 2) {
                throw new \Exception('Formato de respuesta inválido de la API');
            }

            $dolarOficial = $dolar[0]['venta'] ?? 0;
            $dolarBlue = $dolar[1]['venta'] ?? 0;
            $dolarIntermedio = ($dolarOficial + $dolarBlue) / 2;

            $dolarData = [
                'dolarOficial' => $dolarOficial,
                'dolarBlue' => $dolarBlue,
                'dolarIntermedio' => $dolarIntermedio,
                'lastUpdate' => now()->format('d/m/Y H:i:s'),
                'error' => null,
                'source' => 'API'
            ];

            // Cachear los datos
            Cache::put(self::CACHE_KEY, $dolarData, self::CACHE_TTL);

            Log::info('✅ Tasas del dólar actualizadas exitosamente', [
                'oficial' => $dolarOficial,
                'blue' => $dolarBlue,
                'intermedio' => $dolarIntermedio
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en UpdateDolarRatesJob: ' . $e->getMessage(), [
                'attempt' => $this->attempts(),
                'job_id' => $this->job->getJobId()
            ]);

            // Si es el último intento, marcar el caché como desactualizado
            if ($this->attempts() >= $this->tries) {
                $this->markCacheAsStale();
            }

            throw $e;
        }
    }

    /**
     * Marca el caché como desactualizado
     */
    private function markCacheAsStale(): void
    {
        $staleData = Cache::get(self::CACHE_KEY);
        if ($staleData) {
            $staleData['error'] = 'Datos desactualizados - Error en la última actualización';
            $staleData['lastUpdate'] = now()->format('d/m/Y H:i:s');
            Cache::put(self::CACHE_KEY, $staleData, 60); // Cache por 1 minuto
        }
    }

    /**
     * Maneja el fallo del job
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('❌ UpdateDolarRatesJob falló definitivamente', [
            'error' => $exception->getMessage(),
            'job_id' => $this->job?->getJobId()
        ]);
    }
}
