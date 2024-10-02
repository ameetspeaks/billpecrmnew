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
    public $statusLabel;
    /**
     * Create a new event instance.
     */
    public function __construct($order, $statusLabel)
    {
        $this->order = $order;
        $this->statusLabel = $statusLabel;
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
            'current_status' => $this->statusLabel,
            'current_status_id' => $this->order->order_status,
            'message' => $this->getMessageForStatus($this->statusLabel),
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