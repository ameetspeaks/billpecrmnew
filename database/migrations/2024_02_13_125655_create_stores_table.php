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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('zone_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('store_type')->nullable();
            $table->string('module_id')->nullable();
            $table->string('store_image')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('address')->nullable();
            $table->string('pincode')->nullable();
            $table->string('city')->nullable();
            $table->string('gst')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('package_id')->nullable();
            $table->string('package_active_date')->nullable();
            $table->string('package_valid_date')->nullable();
            $table->string('package_amount')->nullable();
            $table->string('package_status')->nullable();
            $table->string('store_status')->default('1');
            $table->string('store_open_time')->nullable();
            $table->string('store_close_time')->nullable();
            $table->text('store_days')->nullable();
            $table->text('last_homepage_video_datetime')->nullable();
            $table->string('featured')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('rating')->nullable();
            $table->string('online_status')->nullable();
            $table->string('store_wallet')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
