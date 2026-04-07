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
            \Log::warning('Usuario no autenticado intentando acceder', [
                'url' => $request->url(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            return redirect()->route('login.index')
                ->with('error', 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente');
        }
        return $next($request);
    }
}
