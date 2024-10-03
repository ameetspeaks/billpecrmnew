<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_delivery_details', function (Blueprint $table) {
            $table->id();
            $table->string('store_id');
            $table->string('delivery_status')->nullable();
            $table->string('range')->nullable();
            $table->string('radius')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('minimum_order_amount')->nullable();
            $table->string('delivery_charge')->nullable()->comment('0 = delivery partner && 1 = self delivery');
            $table->string('packaging_charge')->nullable();
            $table->string('processing_time')->nullable();
            $table->string('delivery_mode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_delivery_details');
    }
};
