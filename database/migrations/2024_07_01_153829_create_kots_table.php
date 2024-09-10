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
        Schema::create('kots', function (Blueprint $table) {
            $table->id();
            $table->string('store_id');
            $table->string('refresh_token')->nullable();
            $table->text('order_type')->nullable();
            $table->string('min_delivery_order_amount')->nullable();
            $table->string('min_delivery_fees')->nullable();
            $table->string('min_packaging_order_amount')->nullable();
            $table->string('min_packaging_fees')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kots');
    }
};
