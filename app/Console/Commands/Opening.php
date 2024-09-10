<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class Opening extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:opening';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Good Morning to Store opening time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            if($user->device_token)
            {
                $postdata = '{
                    "to" : "'.$user->device_token.'",
                    "notification" : {
                        "body" : "Good Morning! Aaj ka shubh Vichar dekhe",
                        "title": "Good Morning"
                    },
                    "data" : {
                        "type": "Dashboard"
                    },
                    }';
                $sendNotification = \App\Helpers\Notification::send($postdata);
            }
        }
    }
}
