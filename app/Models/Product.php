<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table  = 'products';
    public $timestamps = true;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Categoría a la que pertenece
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Recetas que usan este producto
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    // Ítems de pedido que incluyen este producto
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scope: solo productos activos
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
