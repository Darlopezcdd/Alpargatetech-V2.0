<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
//    public function handle(Request $request, Closure $next)
//    {
//        $user = auth()->user();
//
//        // Si el usuario está logueado pero tiene un código de 2FA activo en la DB
//        if (auth()->check() && $user->two_factor_code) {
//            // Si no está en la página de verificación, lo mandamos allá
//            if (!$request->is('verify-2fa*')) {
//                return redirect()->route('verify-2fa.index');
//            }
//        }
//
//        return $next($request);
//    }

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Lógica de experto: Si tiene código pendiente, lo bloqueamos...
        if (auth()->check() && $user->two_factor_code) {

            // ...EXCEPTO si está en la página de verificación O si quiere cerrar sesión
            if (!$request->is('verify-2fa*') && !$request->routeIs('logout')) {
                return redirect()->route('verify-2fa.index');
            }
        }

        return $next($request);
    }
}
