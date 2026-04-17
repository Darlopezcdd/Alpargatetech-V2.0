<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pedidos del restaurante.
 * 'table_id' + 'user_id' (mesero) son los actores principales.
 * 'client_id' es opcional — para facturación nominal.
 * 'status' sigue el flujo: Anotado → En Cocina → En Preparación → Listo → Entregado.
 * 'total' se recalcula por el OrderService en cada modificación.
 * Índice en (table_id, status) para consultas del panel de mesas.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')
                  ->constrained('tables')
                  ->comment('Mesa a la que pertenece el pedido');
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->comment('Mesero que tomó el pedido');
            $table->foreignId('client_id')
                  ->nullable()
                  ->constrained('clients')
                  ->nullOnDelete()
                  ->comment('Cliente (opcional — para facturación)');
            $table->string('status', 30)->default('Anotado')
                  ->comment('Anotado | En Cocina | En Preparación | Listo | Entregado | Cancelado');
            $table->decimal('total', 10, 2)->default(0)->comment('Total calculado por OrderService');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['table_id', 'status'], 'idx_orders_table_status');
            $table->index('status', 'idx_orders_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
