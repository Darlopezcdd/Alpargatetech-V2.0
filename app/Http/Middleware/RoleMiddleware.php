<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Maneja una solicitud entrante.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles Los roles permitidos (admin, mesero, cocinero)
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        if (!in_array(Auth::user()->role->value, $roles)) {
            abort(403, 'Acceso denegado: Tu rol no tiene permisos para esta área.');
        }

        return $next($request);
    }
}
