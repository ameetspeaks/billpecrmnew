<?php

namespace App\Jobs;

use App\Models\CustomerOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateOrderStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $customerOrder;
    public function __construct(CustomerOrder $customerOrder)
    {
        $this->customerOrder = $customerOrder;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->customerOrder->order_status = 4;
        $this->customerOrder->save();
    }
}
