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
        Schema::create('package_transections', function (Blueprint $table) {
            $table->id();
            $table->string('productOrder_id')->nullable();
            $table->string('store_id')->nullable();
            $table->string('cf_payment_id')->nullable();
            $table->string('order_amount')->nullable();
            $table->string('order_id')->nullable();
            $table->string('payment_amount')->nullable();
            $table->string('payment_completion_time')->nullable();
            $table->string('payment_currency')->nullable();
            $table->string('payment_group')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_transections');
    }
};
