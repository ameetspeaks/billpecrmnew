<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DPDetailToCustomerEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $order;
    public $DPDetail;

    public function __construct($order, $DPDetail)
    {
        $this->order = $order;
        $this->DPDetail = $DPDetail;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [new Channel('customer-'.$this->order->user_id)];
    }

    public function broadcastAs()
    {
        return 'notify-to-customer';  // Event name
    }

    public function broadcastWith()
    {
        return [
            "name" => $this->DPDetail->name,
            "whatsapp_no" => $this->DPDetail->whatsapp_no
        ];
    }
}
