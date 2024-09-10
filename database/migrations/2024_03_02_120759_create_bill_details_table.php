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
        Schema::create('bill_details', function (Blueprint $table) {
            $table->id();
            $table->string('store_id')->nullable();
            $table->string('staff_id')->nullable();
            $table->text('product_detail')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_number')->nullable();
            $table->string('amount')->nullable();
            $table->string('discount')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('due_amount')->nullable();
            $table->string('due_date')->nullable();
            $table->string('payment_methord')->nullable();
            $table->string('is_gst')->nullable();
            $table->string('GST5')->nullable();
            $table->string('GST12')->nullable();
            $table->string('GST18')->nullable();
            $table->string('GST28')->nullable();
            $table->string('GST5BeforeAmount')->nullable();
            $table->string('GST12BeforeAmount')->nullable();
            $table->string('GST18BeforeAmount')->nullable();
            $table->string('GST28BeforeAmount')->nullable();
            $table->string('totalcessAmount')->nullable();
            $table->string('totalcessBeforeAmount')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('combined_id')->nullable();
            $table->string('bill_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_details');
    }
};
