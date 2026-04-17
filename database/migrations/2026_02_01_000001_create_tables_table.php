<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Mesas del restaurante.
 * Campo 'number' único — evita duplicados físicos.
 * 'status' controlado por el Enum TableStatus.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('number')->unique()->comment('Número visible de la mesa');
            $table->unsignedSmallInteger('capacity')->default(4)->comment('Personas máximas');
            $table->string('status', 30)->default('Libre')->comment('Libre | Ocupada | Reservada');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
