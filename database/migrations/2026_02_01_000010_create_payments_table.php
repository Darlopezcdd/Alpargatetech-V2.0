<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pagos registrados por pedido.
 * Relación 1:1 con orders (un pedido, un pago).
 * 'payment_method': Efectivo | Tarjeta | Transferencia.
 * 'paid_at' es el timestamp exacto del pago — diferente de created_at.
 * 'amount' se copia del total del pedido al momento del pago.
 * Índice en payment_method para reportes de métodos de pago.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->comment('Pedido pagado');
            $table->decimal('amount', 10, 2)->comment('Monto total cobrado');
            $table->string('payment_method', 30)
                  ->comment('Efectivo | Tarjeta | Transferencia');
            $table->timestamp('paid_at')->nullable()->comment('Momento exacto del pago');
            $table->timestamps();
            $table->softDeletes();

            $table->index('payment_method', 'idx_payments_method');
            $table->index('paid_at', 'idx_payments_paid_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
