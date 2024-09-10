<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BillDetail;

class CustomerDue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:customer-due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Customer (12PM)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $customers = BillDetail::with('store')->where('due_date',date('Y-m-d'))->where('customer_name','!=', null)->orderBy('created_at','DESC')->get()->unique('customer_name');
       
        foreach ($customers as $customer) {
            if($customer->store->user->device_token)
            {
                $postdata = '{
                    "to" : "'.$customer->store->user->device_token.'",
                    "notification" : {
                        "body" : "'.$customer->customer_name.' ki udhari Mil gayi kya? Udhar Manage kare",
                        "title": "Customer due amount"
                    },
                    "data" : {
                        "type": "Customer"
                    },
                    }';
                $sendNotification = \App\Helpers\Notification::send($postdata);
            }

            $phone = '91'.$customer->customer_number;
                $postdata = '{
                    "messaging_product": "whatsapp", 
                    "to" : "'.$phone.'",
                    "type": "template",
                    "template": {
                        "name": "customer_lending_on_reminder_due_date",
                        "language": {"code": "hi"},
                        "components": [
                            {
                                "type": "header",
                                "parameters": [
                                    {
                                        "type": "text",
                                        "text": "'.$customer->due_amount.'"
                                    }
                                ]
                            },
                            {
                                "type": "body",
                                "parameters": [
                                    {
                                        "type": "text",
                                        "text": "'.$customer->customer_name.'"
                                    },
                                    {
                                        "type": "text",
                                        "text": "'.$customer->store->shop_name.'"
                                    },
                                    {
                                        "type": "text",
                                        "text": "'.$customer->due_amount.'"
                                    },
                                    {
                                        "type": "text",
                                        "text": "'.$customer->store->user->whatsapp_no.'"
                                    }
                                ]
                            },
                            {
                                "type": "button",
                                "sub_type": "url",
                                "index": "0",
                                "parameters": [
                                {
                                    "type": "payload",
                                    "payload": "invoice/'.$customer->store_id.'/'.$customer->combined_id.'"
                                }
                                ]
                            }
                        ]
                    }
                }';

                $sendOtpResponse = \App\Http\Controllers\CommonController::sendWhatsappOtp($postdata);
        }
    }
}
