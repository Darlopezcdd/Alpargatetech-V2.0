<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table   = 'categories';
    public $timestamps = true;

    protected $fillable = ['name'];

    // Productos de esta categoría
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Solo productos activos de esta categoría
    public function activeProducts()
    {
        return $this->hasMany(Product::class, 'category_id')->where('is_active', true);
    }
}
