<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\SessionLog;
use App\Enums\UserRole; // Asegúrate de importar tu Enum

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Campos que se pueden llenar masivamente.
     * Es vital para que el LoginController pueda actualizar el login_at.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'   // REQUERIDO para RF-02
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Unificamos todos los casts en este método.
     * Esto convierte automáticamente los datos de la DB a objetos PHP.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class // Convierte el string 'admin' al objeto Enum
        ];
    }

    /**
     * Relación con la tabla de auditoría de sesiones.
     */
    public function sessions()
    {
        return $this->hasMany(SessionLog::class, 'user_id');
    }
}
