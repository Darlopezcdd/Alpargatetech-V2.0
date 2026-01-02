<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;
    protected $table = 'order_items';
    public $timestamps = false;
    protected $fillable = ['order_id', 'product_id', 'quantity', 'notes', 'subtotal'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
