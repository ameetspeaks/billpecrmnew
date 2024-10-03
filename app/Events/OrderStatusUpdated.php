<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $order;
    /**
     * Create a new event instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('order-tracking');
    }

    public function broadcastAs()
    {
        return 'order-tracker';  // This should match the event name in your Pusher listener
    }

    public function broadcastWith()
    {
        return [
            'order_id' => $this->order->id,
            'tracking_code' => $this->order->unique_id,
            'current_status' => $this->order->orderStatus->name,
            'current_status_id' => $this->order->orderStatus->id,
            'merchant_order_status_id' => $this->order->merchantOrderStatus->id,
            'd_p_order_status_id' => $this->order->DPOrderStatus->id,
            'message' => $this->getMessageForStatus($this->order->orderStatus->name),
        ];
    }

    private function getMessageForStatus($statusLabel)
    {
        switch ($statusLabel) {
            case 'Pending':
                return 'Your order is pending and awaiting confirmation.';
            case 'Confirmed':
                return 'Your order has been confirmed.';
            case 'Processing':
                return 'Your order is being processed.';
            case 'Handover':
                return 'Your order has been handed over for delivery.';
            case 'Out for delivery':
                return 'Your order is out for delivery.';
            case 'Delivered':
                return 'Your order has been delivered successfully.';
            case 'Canceled':
                return 'Your order has been canceled.';
            default:
                return 'Status update is unavailable.';
        }
    }
}