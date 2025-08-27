<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login.index');
        }

        $user = auth()->user();
        $allowedRoles = array_merge([$role], $roles);

        if (!$user->hasAnyRole($allowedRoles)) {
            abort(403, 'Acceso denegado. No tienes los permisos necesarios.');
        }

        return $next($request);
    }
}
