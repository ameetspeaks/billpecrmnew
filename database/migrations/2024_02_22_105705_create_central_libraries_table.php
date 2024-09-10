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
        Schema::create('central_libraries', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('store_id')->nullable();
            $table->string('module_id')->nullable();
            $table->string('category')->nullable();
            $table->string('subCategory_id')->nullable();
            $table->string('barcode')->nullable();
            $table->string('barcode_two')->nullable();
            $table->string('product_image')->nullable();
            $table->string('product_name')->nullable();
            $table->string('unit')->nullable();
            $table->string('package_weight')->nullable();
            $table->string('package_size')->nullable();
            $table->string('quantity')->nullable();
            $table->string('mrp')->nullable();
            $table->string('retail_price')->nullable();
            $table->string('wholesale_price')->nullable();
            $table->string('members_price')->nullable();
            $table->string('purchase_price')->nullable();
            $table->string('stock')->nullable();
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
        Schema::dropIfExists('central_libraries');
    }
};
