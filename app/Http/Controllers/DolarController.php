<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DolarController extends Controller
{
    private const API_URL = 'https://dolarapi.com/v1/dolares';
    private const CACHE_KEY = 'dolar_rates';
    private const CACHE_TTL = 300; // 5 minutos
    private const TIMEOUT = 10; // 10 segundos

    public function index()
    {
        try {
            // Intentar obtener datos del caché primero
            $dolarData = Cache::get(self::CACHE_KEY);
            
            if ($dolarData) {
                return view('sections.dolar', $dolarData);
            }

            // Si no hay caché, hacer la petición HTTP optimizada
            $dolarData = $this->fetchDolarData();
            
            // Cachear los datos para futuras consultas
            Cache::put(self::CACHE_KEY, $dolarData, self::CACHE_TTL);
            
            return view('sections.dolar', $dolarData);
            
        } catch (\Exception $e) {
            Log::error('Error al obtener datos del dólar: ' . $e->getMessage());
            
            // Intentar obtener datos del caché aunque estén expirados
            $fallbackData = Cache::get(self::CACHE_KEY);
            if ($fallbackData) {
                return view('sections.dolar', $fallbackData);
            }
            
            // Datos por defecto en caso de error
            return view('sections.dolar', [
                'dolarOficial' => 0,
                'dolarBlue' => 0,
                'dolarIntermedio' => 0,
                'error' => 'No se pudieron obtener los datos del dólar en este momento.',
                'lastUpdate' => null
            ]);
        }
    }

    /**
     * Obtiene los datos del dólar de forma optimizada
     */
    private function fetchDolarData(): array
    {
        // Usar HTTP Client de Laravel con timeout y retry
        $response = Http::timeout(self::TIMEOUT)
            ->retry(2, 1000) // 2 reintentos con 1 segundo de espera
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

        return [
            'dolarOficial' => $dolarOficial,
            'dolarBlue' => $dolarBlue,
            'dolarIntermedio' => $dolarIntermedio,
            'lastUpdate' => now()->format('d/m/Y H:i:s'),
            'error' => null
        ];
    }

    /**
     * Endpoint API para obtener datos del dólar (opcional)
     */
    public function api()
    {
        try {
            $dolarData = Cache::get(self::CACHE_KEY);
            
            if (!$dolarData) {
                $dolarData = $this->fetchDolarData();
                Cache::put(self::CACHE_KEY, $dolarData, self::CACHE_TTL);
            }

            return response()->json([
                'success' => true,
                'data' => $dolarData,
                'cached' => Cache::has(self::CACHE_KEY),
                'timestamp' => now()->toISOString()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 500);
        }
    }

    /**
     * Limpia el caché del dólar (útil para testing)
     */
    public function clearCache()
    {
        Cache::forget(self::CACHE_KEY);
        return response()->json(['message' => 'Caché del dólar limpiado']);
    }
}
