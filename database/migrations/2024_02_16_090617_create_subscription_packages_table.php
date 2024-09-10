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
        Schema::create('subscription_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('discription')->nullable();
            $table->string('image')->nullable();
            $table->string('subscription_price')->nullable();
            $table->string('discount_price')->nullable();
            $table->string('validity_days')->nullable();
            $table->text('benefits')->nullable();
            $table->text('termsandcondition')->nullable();
            $table->string('offer')->nullable();
            $table->string('coupan_no')->nullable();
            $table->string('coupan_title')->nullable();
            $table->string('coupan_logo')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_packages');
    }
};
