<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Herramienta de autenticación
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesa el login (RF-01)
//    public function login(Request $request)
//    {
//        $request->validate([
//            'email' => 'required|email',
//            'password' => 'required',
//        ], [
//            'email.required' => 'El correo es obligatorio para entrar.',
//            'email.email' => 'Debes ingresar un formato de correo válido.',
//            'password.required' => 'La contraseña es obligatoria.',
//        ]);
//
//        $credentials = $request->only('email', 'password');
//
//        if (Auth::attempt($credentials)) {
//            $this->authenticated($request, Auth::user());
//            return redirect()->intended('/dashboard');
//        }
//
//        return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
//    }









    protected function authenticated(Request $request, $user)
    {
        $user->sessions()->create([
            'ip_address' => $request->ip(),
            'login_at' => now(),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }






//    public function store(Request $request)
//    {
//        $request->validate([
//            'email' => 'required|email',
//            'password' => 'required',
//        ]);
//
//        // 1. Intentar validar las credenciales
//        if (Auth::attempt($request->only('email', 'password'))) {
//            $user = Auth::user();
//
//            // 2. Generar y enviar el código de 2FA
//            $user->generateTwoFactorCode();
//
//            // 3. Redirigir a la vista donde se ingresa el código
//            return redirect()->route('verify-2fa.index');
//        }
//
//        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
//    }

// app/Http/Controllers/LoginController.php

//    public function login(Request $request)
//    {
//        $request->validate([
//            'email' => 'required|email',
//            'password' => 'required',
//        ]);
//
//        $credentials = $request->only('email', 'password');
//
//        if (Auth::attempt($credentials)) {
//            $user = Auth::user();
//
//            // 1. Generar y enviar el código
//            $user->generateTwoFactorCode();
//
//            // 2. IMPORTANTE: Cerramos la sesión pero recordamos al usuario en la sesión del navegador
//            // para que el middleware no lo deje pasar sin el código.
//            return redirect()->route('verify-2fa.index');
//        }
//
//        return back()->withErrors(['email' => 'Las credenciales no coinciden.']);
//    }



    public function login(Request $request)
    {
        // Crear una clave única para el usuario basada en su email e IP
        $throttleKey = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());

        // 1. Verificar si ya superó el límite de 3 intentos
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Demasiados intentos. Acceso bloqueado por " . ceil($seconds / 60) . " minutos."
            ]);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Si el login es exitoso, limpiamos el contador de intentos
            RateLimiter::clear($throttleKey);

            $user = Auth::user();
            $user->generateTwoFactorCode(); // Tu lógica de 2FA ya existente
            return redirect()->route('verify-2fa.index');
        }

        // 2. Si falla, registramos un "hit" que expira en 600 segundos (10 minutos)
        RateLimiter::hit($throttleKey, 600);

        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }
}
