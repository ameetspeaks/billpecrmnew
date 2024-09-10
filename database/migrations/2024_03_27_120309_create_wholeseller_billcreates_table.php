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
        Schema::create('wholeseller_billcreates', function (Blueprint $table) {
            $table->id();
            $table->string('store_id')->nullable();
            $table->string('product_detail')->nullable();
            $table->string('wholeseller_name')->nullable();
            $table->string('wholeseller_number')->nullable();
            $table->string('amount')->nullable();
            $table->string('discount')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('due_amount')->nullable();
            $table->string('due_date')->nullable();
            $table->string('payment_methord')->nullable();
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
        Schema::dropIfExists('wholeseller_billcreates');
    }
};
