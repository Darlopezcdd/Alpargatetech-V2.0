<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\TableStatus;

class Mesa extends Model
{
    use SoftDeletes;

    protected $table = 'tables';
    public $timestamps = false;

    protected $fillable = [
        'number',
        'capacity',
        'status'
    ];

    protected $casts = [
        'status' => TableStatus::class,
    ];
    public function currentOrder()
    {
        // Buscamos el último pedido de esta mesa que NO esté Entregado ni Cancelado
        return $this->hasOne(Order::class, 'table_id')
            ->whereNotIn('status', [
                \App\Enums\OrderStatus::ENTREGADO,
                \App\Enums\OrderStatus::CANCELADO
            ])
            ->latest();
    }
}
