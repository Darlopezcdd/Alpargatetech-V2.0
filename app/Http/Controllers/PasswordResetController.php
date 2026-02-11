<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use App\Services\AuditLogger;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $code = strtoupper(Str::random(6)); // Generar código alfanumérico de 6 dígitos

        // Guardar o actualizar el código en la base de datos
        DB::table('password_reset_codes')->updateOrInsert(
            ['email' => $request->email],
            [
                'code' => $code,
                'created_at' => now()
            ]
        );

        // Enviar el correo
        Mail::to($request->email)->send(new ResetPasswordCode($code));

        AuditLogger::log('Password Reset Request', "Solicitud de restablecimiento de contraseña para: {$request->email}");

        return redirect()->route('password.verify', ['email' => $request->email]);
    }

    public function showVerifyForm(Request $request)
    {
        return view('auth.verify-code', ['email' => $request->query('email')]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required'
        ]);

        $record = DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        // Verificar si existe y si no ha expirado (ej. 15 minutos)
        if (!$record || now()->diffInMinutes($record->created_at) > 15) {
            return back()->withErrors(['code' => 'El código es inválido o ha expirado.']);
        }

        return redirect()->route('password.reset', ['email' => $request->email, 'code' => $request->code]);
    }

    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', [
            'email' => $request->query('email'),
            'code' => $request->query('code')
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->symbols()],
        ]);

        // Verificar código nuevamente por seguridad
        $record = DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Solicitud inválida.']);
        }

        // Actualizar contraseña
        $user = User::where('email', $request->email)->first();
        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->save();

        // Eliminar el código usado
        DB::table('password_reset_codes')->where('email', $request->email)->delete();

        AuditLogger::log('Password Reset Success', "Contraseña restablecida exitosamente para: {$request->email}", $user->id);

        return redirect()->route('login')->with('status', '¡Contraseña restablecida correctamente!');
    }
}
