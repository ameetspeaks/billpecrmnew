<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminNewOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
  public $data;
    /**
     * Create a new event instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('admin-order-alert'), // Channel name
        ];
    }

    public function broadcastAs()
    {
        return 'new-order';  // Event name
    }

    public function broadcastWith()
    {
//        return [
//            "order_id" => $this->data->id,
//            "order_date" => $this->data->created_at,
//            "order_total" => $this->data->total,
//            "order_status" => $this->data->status,
//        ];
    }
}
