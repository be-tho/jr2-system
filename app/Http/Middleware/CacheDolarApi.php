<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheDolarApi
{
    private const CACHE_TTL = 300; // 5 minutos

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo cachear para usuarios autenticados y consultas GET
        if (!auth()->check() || !$request->isMethod('GET')) {
            return $next($request);
        }

        // Crear clave de caché basada en la ruta y parámetros
        $cacheKey = 'dolar_api_' . md5($request->fullUrl());
        
        // Verificar si existe en caché
        if (Cache::has($cacheKey)) {
            $this->logCacheHit($cacheKey);
            return Cache::get($cacheKey);
        }

        // Si no existe en caché, ejecutar la consulta y cachear el resultado
        $response = $next($request);
        
        // Solo cachear respuestas exitosas
        if ($response->getStatusCode() === 200) {
            Cache::put($cacheKey, $response, self::CACHE_TTL);
            $this->logCacheMiss($cacheKey);
        }

        return $response;
    }

    /**
     * Log cuando se sirve desde caché
     */
    private function logCacheHit(string $cacheKey): void
    {
        if (config('app.debug')) {
            \Log::info('📦 Dólar API: Sirviendo desde caché', ['key' => $cacheKey]);
        }
    }

    /**
     * Log cuando se cachea una nueva respuesta
     */
    private function logCacheMiss(string $cacheKey): void
    {
        if (config('app.debug')) {
            \Log::info('💾 Dólar API: Cacheando nueva respuesta', ['key' => $cacheKey, 'ttl' => self::CACHE_TTL]);
        }
    }
}
