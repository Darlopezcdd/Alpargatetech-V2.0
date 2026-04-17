<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;
use App\Enums\OrderStatus;
use App\Enums\TableStatus;
use App\Events\OrderSentToKitchen;
use App\Events\OrderReadyToServe;
use App\Events\TableStatusUpdated;
use Illuminate\Support\Facades\DB;

class OrderService
{
    // Crear pedido con transacción atómica
    public function create(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $order = Order::create([
                'table_id' => $data['table_id'],
                'user_id'  => auth()->id(),
                'status'   => OrderStatus::EN_COCINA,
                'total'    => 0,
            ]);

            $total = 0;
            foreach ($data['items'] as $item) {
                $product  = Product::findOrFail($item['product_id']);
                $subtotal = $product->price * $item['quantity'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'subtotal'   => $subtotal,
                    'notes'      => $item['notes'] ?? null,
                ]);

                $total += $subtotal;
            }

            $order->update(['total' => $total]);
            $order->mesa->update(['status' => TableStatus::OCUPADA]);

            broadcast(new OrderSentToKitchen($order));

            AuditLogger::log(
                'Pedido creado',
                "Mesa #{$order->mesa->number} — {$order->items->count()} ítem(s) — Total: \${$total}",
                auth()->id()
            );

            return $order->fresh(['items.product', 'mesa']);
        });
    }

    // Añadir producto a pedido existente
    public function addProduct(Order $order, array $data): void
    {
        DB::transaction(function () use ($order, $data) {
            $product  = Product::findOrFail($data['product_id']);
            $subtotal = $product->price * $data['quantity'];

            $item = $order->items()->create([
                'product_id' => $product->id,
                'quantity'   => $data['quantity'],
                'subtotal'   => $subtotal,
                'notes'      => $data['notes'] ?? null,
            ]);

            $order->increment('total', $subtotal);
            $item->load('product');

            broadcast(new OrderSentToKitchen($order, collect([$item])));

            AuditLogger::log(
                'Producto añadido',
                "'{$product->name}' x{$data['quantity']} al Pedido #{$order->id}",
                auth()->id()
            );
        });
    }

    // Enviar pedido a cocina
    public function sendToKitchen(Order $order): void
    {
        $order->update(['status' => OrderStatus::EN_COCINA]);
        broadcast(new OrderSentToKitchen($order));
        AuditLogger::log('Pedido a cocina', "Pedido #{$order->id} enviado a cocina", auth()->id());
    }

    // Cambiar estado del pedido y broadcast
    public function updateStatus(Order $order, string $status): void
    {
        $order->update(['status' => $status]);

        $readyStatuses = [
            OrderStatus::EN_PREPARACION->value,
            OrderStatus::LISTO->value,
            'En Preparación',
            'Listo',
        ];

        if (in_array($status, $readyStatuses)) {
            $order->load(['mesa', 'items.product']);
            broadcast(new OrderReadyToServe($order));
        }

        broadcast(new TableStatusUpdated($order->table_id, $status, $order->id));

        AuditLogger::log('Estado pedido', "Pedido #{$order->id} → {$status}", auth()->id());
    }

    // Procesar pago y liberar mesa
    public function processPayment(Order $order, string $paymentMethod): void
    {
        DB::transaction(function () use ($order, $paymentMethod) {
            Payment::create([
                'order_id'       => $order->id,
                'amount'         => $order->total,
                'payment_method' => $paymentMethod,
                'paid_at'        => now(),
            ]);

            $order->update(['status' => OrderStatus::ENTREGADO]);
            $order->mesa->update(['status' => TableStatus::LIBRE]);

            AuditLogger::log(
                'Pago procesado',
                "Pedido #{$order->id} — Método: {$paymentMethod} — Total: \${$order->total}",
                auth()->id()
            );
        });
    }
}
