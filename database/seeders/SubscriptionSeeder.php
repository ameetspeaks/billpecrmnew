<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPackage;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subPackage = SubscriptionPackage::create([
            'name' => 'Trial',
            'subscription_price' => '0',
            'validity_days' => '7',
            'status'=>'1',
        ]);
    }
}
