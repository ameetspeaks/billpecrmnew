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
        Schema::create('customer_coupans', function (Blueprint $table) {
            $table->id();
            $table->text('zone_id')->nullable();
            $table->text('subzone_id')->nullable();
            $table->text('store_id')->nullable();
            $table->text('module_id')->nullable();
            $table->text('category_id')->nullable();
            $table->text('image')->nullable();
            $table->string('title')->nullable();
            $table->string('sub_heading')->nullable();
            $table->string('discount')->nullable();
            $table->string('discountType')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('coupan_code')->nullable();
            $table->string('maximum_discount_amount')->nullable();
            $table->string('minimum_purchase')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_coupans');
    }
};
