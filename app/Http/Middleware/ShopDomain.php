<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopDomain
{
    /**
     * Handle an incoming request.
     * Detecta si el dominio es el subdominio de la tienda
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $shopSubdomain = config('app.shop_subdomain', 'shop');
        
        // Extraer el subdominio
        $parts = explode('.', $host);
        $subdomain = count($parts) > 2 ? $parts[0] : null;
        
        // En desarrollo local, permitir acceso siempre
        $isLocal = in_array($host, ['localhost', '127.0.0.1']) || 
                   str_contains($host, 'localhost') || 
                   str_contains($host, '127.0.0.1') ||
                   str_contains($host, '.test') || // Laravel Valet
                   str_contains($host, '.local');   // Laravel Valet
        
        // Si el subdominio coincide con el de la tienda, o estamos en localhost (desarrollo)
        if ($subdomain === $shopSubdomain || $isLocal) {
            // Configurar el dominio de la sesión para que funcione entre subdominios (solo en producción)
            if (!$isLocal && $subdomain === $shopSubdomain) {
                config(['session.domain' => '.' . implode('.', array_slice($parts, -2))]);
            }
        }
        
        return $next($request);
    }
}
