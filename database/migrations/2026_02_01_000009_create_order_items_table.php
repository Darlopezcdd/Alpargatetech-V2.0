<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Ítems individuales de cada pedido.
 * 'subtotal' = price × quantity — desnormalizado para velocidad de consulta.
 * 'notes' permite notas especiales del comensal (sin cebolla, extra queso, etc.).
 * SoftDelete preserva historial para reportes incluso si el producto es eliminado.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade')
                  ->comment('Pedido al que pertenece este ítem');
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->comment('Producto: se preserva aunque el producto sea eliminado (soft delete)');
            $table->unsignedSmallInteger('quantity')->comment('Cantidad pedida (max 999)');
            $table->decimal('subtotal', 8, 2)->comment('subtotal = price × quantity al momento del pedido');
            $table->string('notes', 255)->nullable()->comment('Notas especiales del comensal');
            $table->timestamps();
            $table->softDeletes();

            $table->index('order_id', 'idx_order_items_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
