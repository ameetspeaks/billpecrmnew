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
        Schema::create('warehouse_products', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('store_id')->nullable();
            $table->string('module_id')->nullable();
            $table->string('category')->nullable();
            $table->string('subCategory_id')->nullable();
            $table->string('barcode')->nullable();
            $table->string('product_image')->nullable();
            $table->string('product_name')->nullable();
            $table->string('primary_unit')->nullable();
            $table->string('secondary_unit')->nullable();
            $table->text('primary_qtn')->nullable();
            $table->string('secondary_qtn')->nullable();
            $table->string('mrp_box')->nullable();
            $table->string('mrp_pc')->nullable();
            $table->string('stock_box')->nullable();
            $table->string('stock_pc')->nullable();
            $table->string('low_stock')->nullable();
            $table->string('gst')->nullable();
            $table->string('hsn')->nullable();
            $table->string('cess')->nullable();
            $table->string('expiry')->nullable();
            $table->string('tags')->nullable();
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_products');
    }
};
