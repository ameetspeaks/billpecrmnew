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
        Schema::create('package_orders', function (Blueprint $table) {
            $table->id();
            $table->string('store_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('product_details')->nullable();
            $table->string('shipping_name')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_latitude')->nullable();
            $table->string('shipping_longitude')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_code')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('copanCode')->nullable();
            $table->string('coupanAmount')->nullable();
            $table->string('TotalAmount')->nullable();
            $table->string('order_comment')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('combined_id')->nullable();
            $table->string('order_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_orders');
    }
};
