<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\StoreType;

class StoreTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoreType::create(['name' => 'Retail']);
        StoreType::create(['name' => 'Wholesale']);
        StoreType::create(['name' => 'Both']);
    }
}
