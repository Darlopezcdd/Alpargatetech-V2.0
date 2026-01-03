<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Herramienta de autenticación
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    // Procesa el login (RF-01)
    public function login(Request $request) {
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

        return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
    }

    protected function authenticated(Request $request, $user)
    {
        $user->sessions()->create([
            'ip_address' => $request->ip(),
            'login_at' => now(),
        ]);
    }
}
