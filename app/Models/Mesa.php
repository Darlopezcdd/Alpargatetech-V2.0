<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\TableStatus;
use App\Enums\OrderStatus;

class Mesa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tables';
    // Bug fix: la migración SÍ crea timestamps — no desactivar
    public $timestamps = true;

    protected $fillable = [
        'number',
        'capacity',
        'status',
    ];

    protected $casts = [
        'status' => TableStatus::class,
    ];

    /** Pedido activo en esta mesa (no Entregado ni Cancelado). */
    public function currentOrder()
    {
        return $this->hasOne(Order::class, 'table_id')
            ->whereNotIn('status', [
                OrderStatus::ENTREGADO,
                OrderStatus::CANCELADO,
            ])
            ->latest();
    }

    /** Todos los pedidos históricos de la mesa. */
    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id');
    }

    /** ¿La mesa está libre? */
    public function isAvailable(): bool
    {
        return $this->status === TableStatus::LIBRE;
    }
}
