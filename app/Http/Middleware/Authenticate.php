<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // si no esta autenticado redirigir a la pagina de login
        if (!auth()->check()) {
            return redirect()->route('login.index')->with('error', 'Debes iniciar sesión para acceder a esta página');
        }
        return $next($request);
    }
}
