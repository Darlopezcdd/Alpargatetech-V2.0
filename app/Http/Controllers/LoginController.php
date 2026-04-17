<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Services\AuditLogger;

class LoginController extends Controller
{
    // Vista del formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar login con rate limiting y 2FA
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'El correo es obligatorio.',
            'email.email'       => 'Ingresa un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Rate limiting: máximo 3 intentos por 10 minutos
        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Demasiados intentos fallidos. Acceso bloqueado por " . ceil($seconds / 60) . " minutos.",
            ]);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            RateLimiter::clear($throttleKey);

            $user = Auth::user();

            // Registrar sesión activa
            $user->sessions()->create([
                'ip_address' => $request->ip(),
                'login_at'   => now(),
            ]);

            AuditLogger::log('Login', 'Usuario inició sesión exitosamente.', $user->id);

            // Generar y enviar código 2FA por correo
            $user->generateTwoFactorCode();

            return redirect()->route('verify-2fa.index');
        }

        // Registrar intento fallido
        RateLimiter::hit($throttleKey, 600);

        return back()->withErrors(['email' => 'Correo o contraseña incorrectos.']);
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        AuditLogger::log('Logout', 'Usuario cerró sesión.', Auth::id());

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
