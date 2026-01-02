<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Herramienta de autenticación
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    // Muestra el formulario
    public function showLoginForm() {
        return view('auth.login');
    }

    // Procesa el login (RF-01)
    public function login(Request $request) {
        // 1. Validación lógica: Ahorra recursos del servidor (RNF-01)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo es obligatorio para entrar.',
            'email.email' => 'Debes ingresar un formato de correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $this->authenticated($request, Auth::user());
            return redirect()->intended('/dashboard');
        }

        // Regresa con un error amigable si fallan las credenciales
        return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
    }

    // Lógica de Registro de Sesión (Trazabilidad RNF-04)
    protected function authenticated(Request $request, $user)
    {
        // Creem el registre històric a sessions_log
        // Laravel utilitzarà la relació que vas definir al model User
        $user->sessions()->create([
            'ip_address' => $request->ip(),
            'login_at' => now(),
        ]);
    }
}
