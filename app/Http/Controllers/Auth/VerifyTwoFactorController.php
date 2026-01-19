<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class VerifyTwoFactorController extends Controller
{
    public function index()
    {
        return view('auth.verify-2fa'); // Crea esta vista con tu input de 6 dígitos
    }

    public function store(Request $request)
    {
        $request->validate(['code' => 'required|integer']);
        $user = Auth::user();

        // Validar código y expiración
        if ($request->code == $user->two_factor_code && now()->isBefore($user->two_factor_expires_at)) {
            $user->resetTwoFactorCode(); // Limpia el código de la DB
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['code' => 'El código es incorrecto o ha expirado.']);
    }
}
