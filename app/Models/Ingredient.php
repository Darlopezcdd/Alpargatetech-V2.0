<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingredient extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ingredients';

    protected $fillable = [
        'name',
        'unit',
        'stock_actual',
        'stock_minimo',
    ];

    protected $casts = [
        'stock_actual' => 'decimal:2',
        'stock_minimo' => 'decimal:2',
    ];

    // Recetas que usan este ingrediente
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    // Verificar si el stock está por debajo del mínimo
    public function isLowStock(): bool
    {
        return $this->stock_actual <= $this->stock_minimo;
    }

    // Scope: ingredientes con stock bajo
    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock_actual', '<=', 'stock_minimo');
    }
}
