<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Store;

class Report extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily/weekly/Monthly Report Notification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $stores = Store::with('user')->get();
        foreach ($stores as $store) {
            if($store->user->device_token)
            {
                $postdata = '{
                    "to" : "'.$store->user->device_token.'",
                    "notification" : {
                        "body" : "'.$store->shop_name.' aaj ka apka report ready hai! Abhi dekhe",
                        "title": "Billpe Report"
                    },
                    "data" : {
                        "type": "Reports"
                    },
                    }';
                $sendNotification = \App\Helpers\Notification::send($postdata);
            }
        }
    }
}
