<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Recetas: relación producto ↔ ingredientes.
 * Cada fila define cuánto de un ingrediente necesita un producto.
 * Permite implementar descuento automático de inventario al crear pedidos.
 * Índice en (product_id, ingredient_id) para búsquedas rápidas.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade')
                  ->comment('Producto que usa este ingrediente');
            $table->foreignId('ingredient_id')
                  ->constrained('ingredients')
                  ->onDelete('cascade')
                  ->comment('Ingrediente requerido');
            $table->decimal('quantity_required', 10, 2)
                  ->comment('Cantidad del ingrediente por porción del producto');
            $table->timestamps();
            $table->softDeletes();

            // Un ingrediente específico no puede repetirse en la misma receta
            $table->unique(['product_id', 'ingredient_id'], 'uq_recipe_product_ingredient');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
