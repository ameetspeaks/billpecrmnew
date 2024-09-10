<?php

namespace App\Console\Commands;
use App\Models\AppActivity;

use Illuminate\Console\Command;

class DeleteActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-activity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activity Delete in 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $activitys = AppActivity::all();
        foreach($activitys as $activity)
        {
            $date1 = strtotime($activity->created_at);
            $date2 = strtotime(date('Y-m-d H:i:s'));

                        
            $diff = abs($date2 - $date1);
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));

            $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
            $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));

            $totalHOus = $days*24 + $hours;
            if($totalHOus > 24)
            {
                $activity->destroy($activity->id);
            }
        }
    }
}
