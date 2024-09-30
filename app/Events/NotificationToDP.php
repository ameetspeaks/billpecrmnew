<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationToDP implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $newOrderData;
    /**
     * Create a new event instance.
     */
    public function __construct($newOrderData)
    {
        $this->newOrderData = $newOrderData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return new Channel('order-tracking');
    }

    public function broadcastAs()
    {
        return 'notify-to-delivery-partner';  // This should match the event name in your Pusher listener
    }

    public function broadcastWith()
    {
        return $this->newOrderData;
    }
}
