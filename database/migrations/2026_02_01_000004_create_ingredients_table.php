<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Ingredientes del inventario.
 * 'stock_actual' y 'stock_minimo' usan decimal(10,2) para precisión.
 * La alerta de stock bajo se calcula comparando ambos campos.
 * 'unit' define la unidad de medida (kg, g, L, unidad, etc.).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->comment('Nombre del ingrediente');
            $table->string('unit', 20)->comment('Unidad: kg | g | L | ml | unidad | docena');
            $table->decimal('stock_actual', 10, 2)->default(0)->comment('Stock disponible actualmente');
            $table->decimal('stock_minimo', 10, 2)->default(0)->comment('Umbral mínimo — alerta si stock_actual <= stock_minimo');
            $table->timestamps();
            $table->softDeletes();

            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
