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
        $credentials = $request->only('email', 'password');

        // Intenta validar contra la DB (Seguridad RNF-05)
        if (Auth::attempt($credentials)) {
            // Si tiene éxito, dispara la lógica de auditoría
            $this->authenticated($request, Auth::user());
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    // Lógica de Registro de Sesión (Trazabilidad RNF-04)
    protected function authenticated(Request $request, $user) {
        // Actualiza fecha en tabla users
        $user->update(['login_at' => now()]);

        // Crea historial en sessions_log
        $user->sessions()->create([
            'ip_address' => $request->ip(),
            'login_at' => now(),
        ]);
    }
}
