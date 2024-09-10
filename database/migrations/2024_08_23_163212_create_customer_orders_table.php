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
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('store_id');
            $table->string('address_id')->nullable();
            $table->text('product_details');
            $table->string('amount');
            $table->string('coupan_amount')->nullable();
            $table->text('any_other_fee')->nullable();
            $table->string('tip')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('payment_mode')->nullable();
            $table->text('instruction')->nullable();
            $table->string('order_status')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('combined_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('deliveryboy_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_orders');
    }
};
