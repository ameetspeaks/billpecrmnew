<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationToMerchant implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $order;
    public $type;
    public $message;
    public $otherDetail;
    /**
     * Create a new event instance.
     */
    public function __construct($order, $type, $message, $otherDetail)
    {
        $this->order = $order;
        $this->type = $type;
        $this->message = $message;
        $this->otherDetail = $otherDetail;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return [new Channel('merchant-store-'.$this->order['store_id'])];
    }

    public function broadcastAs()
    {
        return 'notify-to-merchant';  // This should match the event name in your Pusher listener
    }

    public function broadcastWith()
    {
        return [
            'order_id' => $this->order->id,
            'tracking_code' => $this->order->unique_id,
            'message' => $this->message,
            'current_status_id' => $this->order->order_status,
            'delivery_km' => $this->otherDetail['delivery_km'],
            'delivery_mode' => $this->otherDetail['delivery_mode'],
            'amount' => $this->order->amount,
            'total_amount' => $this->order->total_amount,
        ];
    }
}
