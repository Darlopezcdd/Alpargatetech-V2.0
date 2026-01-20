<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\OrderStatus;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';
    public $timestamps = true;

    protected $fillable = ['table_id', 'user_id', 'client_id', 'status', 'total'];

    protected $casts = [
        'status' => OrderStatus::class,
        'total' => 'decimal:2',
    ];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'table_id');
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
