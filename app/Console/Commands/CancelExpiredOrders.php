<?php

namespace App\Console\Commands;

use App\Models\CustomerOrder;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelExpiredOrders extends Command
{
    protected $signature = 'orders:cancel-expired';
    protected $description = 'Cancel orders that have exceeded the confirmation timeout';

    public function handle()
    {
        $expiredOrders = CustomerOrder::where('order_status', 1)
            ->where('order_expires_at', '<=', Carbon::now())
            ->get();

        foreach ($expiredOrders as $order) {
            $order->update(['order_status' => 7,
                'merchant_order_status' => 9,
                'd_p_order_status' => 7,
            ]);
        }

        $this->info('Expired orders canceled successfully.');
    }
}

