<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VendorStockPurchase;

class VenderDue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:vender-due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Due date (vendor) 11 AM';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $vendors = VendorStockPurchase::with('store')->where('due_date', date('Y-m-d'))->get();

        foreach ($vendors as $vendor) {
            if($vendor->store->user->device_token)
            {
                $postdata = '{
                    "to" : "'.$vendor->store->user->device_token.'",
                    "notification" : {
                        "body" : "Apke '.$vendor->vendor_name.' ka payment Due Hai, Abhi update kare",
                        "title": "Vendor due amount"
                    },
                    "data" : {
                        "type": "Vendor"
                    },
                    }';
                $sendNotification = \App\Helpers\Notification::send($postdata);
            }
        }
    }
}
