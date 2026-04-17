<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Activos fijos del restaurante.
 * Incluye mesas, sillas, equipos de cocina, electrodomésticos.
 * 'status' puede ser: Operativo | En reparación | Dado de baja.
 * SoftDelete mantiene historial de bajas para auditoría.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fixed_assets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->comment('Nombre del activo');
            $table->text('description')->nullable()->comment('Descripción o características');
            $table->unsignedInteger('quantity')->default(1)->comment('Cantidad de unidades');
            $table->string('status', 30)->default('Operativo')
                  ->comment('Operativo | En reparación | Dado de baja');
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixed_assets');
    }
};
