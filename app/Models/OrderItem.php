<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_items';
    // Bug fix: la migración SÍ crea timestamps — no desactivar
    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'subtotal',  // price × quantity al momento del pedido
        'notes',     // notas especiales del comensal
    ];

    protected $casts = [
        'subtotal'  => 'decimal:2',
        'quantity'  => 'integer',
    ];

    /** Producto de este ítem (con soft delete — preservado aunque se elimine el producto). */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    /** Pedido al que pertenece este ítem. */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
