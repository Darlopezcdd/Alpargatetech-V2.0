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

    public function __construct(Order $order)
    {
        // Cargamos las relaciones para que el cocinero reciba todo el detalle
        $this->order = $order->load(['items.product', 'mesa']);
    }

    public function broadcastOn(): array
    {
        // Canal público para la cocina
        return [new Channel('kitchen-channel')];
    }

    public function broadcastAs(): string
    {
        return 'new-order';
    }
}
