<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\OrderStatus;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table   = 'orders';
    public $timestamps = true;

    protected $fillable = [
        'table_id',
        'user_id',
        'client_id',
        'status',
        'total',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'total'  => 'decimal:2',
    ];

    // Mesa donde se tomó el pedido
    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'table_id');
    }

    // Mesero que tomó el pedido
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Cliente asociado (opcional)
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    // Ítems (detalle del pedido)
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Pago registrado
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
}
