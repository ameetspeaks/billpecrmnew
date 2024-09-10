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
        Schema::create('bill_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('store_id');
            $table->string('bill_id');
            $table->string('token_no');
            $table->string('order_type')->nullable();
            $table->text('order_details')->nullable();
            $table->string('staff_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_tokens');
    }
};
