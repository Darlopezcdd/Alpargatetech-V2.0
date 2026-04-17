<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Clientes del restaurante.
 * Todos los campos de contacto son opcionales — no se fuerza registro.
 * 'identification' sirve para cédula o RUC.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->comment('Nombre completo del cliente');
            $table->string('identification', 30)->nullable()->comment('Cédula o RUC');
            $table->string('email', 150)->nullable()->unique()->comment('Correo para facturación');
            $table->string('phone', 20)->nullable()->comment('Teléfono de contacto');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
