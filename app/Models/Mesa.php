<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Requerido por tu script
use App\Enums\TableStatus;

class Mesa extends Model
{
    use SoftDeletes; // Implementa el deleted_at que agregaste

    // Conexión con tu tabla SQL
    protected $table = 'tables';
    public $timestamps = false;

    // Campos exactos de tu tabla
    protected $fillable = [
        'number',
        'capacity',
        'status'
    ];

    // Mapeo de tipos
    protected $casts = [
        'status' => TableStatus::class,
    ];
}
