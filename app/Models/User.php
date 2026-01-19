<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\SessionLog;
use App\Enums\UserRole; // Asegúrate de importar tu Enum
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,SoftDeletes;


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class
        ];
    }


    public function sessions()
    {
        return $this->hasMany(SessionLog::class, 'user_id');
    }

    public function generateTwoFactorCode()
    {
        // Generar código de 6 dígitos
        $this->two_factor_code = rand(100000, 999999);
        // Definir expiración (10 minutos)
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();

        // Enviar el correo usando la configuración que ya tienes activa
        Mail::to($this->email)->send(new TwoFactorCodeMail($this->two_factor_code));
    }

    public function resetTwoFactorCode()
    {
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

}
