<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Productos del menú.
 * Depende de: categories.
 * 'price' decimal(8,2) cubre precios hasta $999,999.99.
 * 'is_active' permite ocultar del menú sin eliminar.
 * 'stock' es opcional — para restaurantes que controlan porciones.
 * Índice compuesto en (category_id, is_active) para consulta del menú.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade')
                  ->comment('Categoría del menú');
            $table->string('name', 200)->comment('Nombre del plato o bebida');
            $table->decimal('price', 8, 2)->comment('Precio de venta');
            $table->text('description')->nullable()->comment('Descripción para el menú');
            $table->unsignedInteger('stock')->nullable()->comment('Stock de porciones (opcional)');
            $table->boolean('is_active')->default(true)->comment('false = oculto del menú de pedidos');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'is_active'], 'idx_products_category_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
