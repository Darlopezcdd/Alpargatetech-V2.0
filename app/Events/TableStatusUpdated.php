<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TableStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tableId;
    public $status;
    public $orderId;

    /**
     * Create a new event instance.
     *
     * @param int $tableId
     * @param string $status
     * @param int $orderId
     */
    public function __construct($tableId, $status, $orderId)
    {
        $this->tableId = $tableId;
        $this->status = $status;
        $this->orderId = $orderId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('tables'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'tableId' => $this->tableId,
            'status' => $this->status,
            'orderId' => $this->orderId,
        ];
    }

    public function broadcastAs(): string
    {
        return 'table.status.updated';
    }
}
