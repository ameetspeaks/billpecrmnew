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
        Schema::create('change_package_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('store_id')->nullable();
            $table->string('last_package')->nullable();
            $table->string('last_package_price')->nullable();
            $table->string('last_package_date')->nullable();
            $table->string('new_package')->nullable();
            $table->string('new_package_price')->nullable();
            $table->string('new_package_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_package_subscriptions');
    }
};
