<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderSentToKitchen implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $items;

    public function __construct(Order $order, $items = null)
    {
        // Si nos pasan items específicos (ej: adición), los usamos.
        // Si no, cargamos TODA la orden (ej: primera vez).
        if ($items) {
            // Clonamos la orden para no afectar la instancia global si se usara en otro lado
            $this->order = $order;
            // Forzamos la relación 'items' a ser la colección que nos pasaron
            $this->order->setRelation('items', $items);
        } else {
            $this->order = $order->load(['items.product', 'mesa']);
        }
    }

    public function broadcastOn(): array
    {
        // Canal público para la cocina
        return [new Channel('kitchen-channel')];
    }

    public function broadcastWith(): array
    {
        return [
            'order' => [
                'id' => $this->order->id,
                'status' => $this->order->status,
                'mesa' => [
                    'number' => $this->order->mesa->number,
                ],
                // Aquí aseguramos que se manden SOLO los items que tenga cargada la relación en ese momento
                'items' => $this->order->items->map(function ($item) {
                    return [
                        'quantity' => $item->quantity,
                        'notes' => $item->notes,
                        'product' => [
                            'name' => $item->product->name,
                        ],
                    ];
                })->toArray(),
            ],
        ];
    }

    public function broadcastAs(): string
    {
        return 'new-order';
    }
}
