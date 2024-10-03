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
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->decimal('store_to_customer_distance', 10, 2)->default(0)->after('transection_id');
            $table->decimal('dp_to_store_distance', 10, 2)->default(0)->after('store_to_customer_distance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->dropColumn(['store_to_customer_distance', 'dp_to_store_distance']);
        });
    }
};
