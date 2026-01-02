<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionLog extends Model
{
    // 1. Vinculación con la tabla física en PostgreSQL
    protected $table = 'sessions_log';

    // 2. Permite la inserción masiva desde el LoginController
    protected $fillable = ['user_id', 'ip_address', 'login_at'];

    // 3. Desactivamos timestamps automáticos (created_at/updated_at)
    // porque usamos 'login_at' manualmente para la auditoría (RF-01)
    public $timestamps = false;

    /**
     * MEJORA LÓGICA: Convierte el string de la DB en un objeto Carbon.
     * Esto te permitirá comparar fechas o darles formato fácilmente.
     */
    protected $casts = [
        'login_at' => 'datetime',
    ];
}
