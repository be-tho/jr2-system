<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TelescopeAuthorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo permitir acceso a administradores
        if (!auth()->check() || !auth()->user()->hasRole('administrador')) {
            abort(403, 'Acceso denegado a Telescope');
        }

        return $next($request);
    }
}
