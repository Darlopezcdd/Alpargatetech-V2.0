<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'recipes';

    protected $fillable = [
        'product_id',
        'ingredient_id',
        'quantity_required',
    ];

    protected $casts = [
        'quantity_required' => 'decimal:2',
    ];

    // Producto al que corresponde esta receta
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Ingrediente requerido por esta receta
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
