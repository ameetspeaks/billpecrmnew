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
        Schema::create('vendor_stock_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('store_id')->nullable();
            $table->string('bill_number')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('vendor_number')->nullable();
            $table->string('bill_amount')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('credit_amount')->nullable();
            $table->string('due_date')->nullable();
            $table->string('bill_image')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('gst_amount')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_stock_purchases');
    }
};
