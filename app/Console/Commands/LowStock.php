<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Store;
use App\Models\Product;

class LowStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:low-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'When 1 items low in inventory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $stores = Store::with('user')->get();

        foreach ($stores as $store) {
            if($store->user->device_token)
            {
                $products = Product::where('store_id', $store->id)->get();
                $lowStock = [];
                foreach($products as $product){
                    if($product->stock <= $product->low_stock){
                        array_push($lowStock,$product);
                    }
                }
                foreach ($lowStock as $low) 
                {
                    $postdata = '{
                        "to" : "'.$store->user->device_token.'",
                        "notification" : {
                            "body" : "'.$low->product_name.' ka stock khatam hone wala hai!",
                            "title": "Low inventory stock"
                        },
                        "data" : {
                            "type": "Stock"
                        },
                        }';
                    $sendNotification = \App\Helpers\Notification::send($postdata);   
                }
            }
        }
    }
}
