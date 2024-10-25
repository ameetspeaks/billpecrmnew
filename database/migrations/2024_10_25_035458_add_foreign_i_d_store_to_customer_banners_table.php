<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customer_banners', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Store::class)
                ->after('id')
                ->nullable()
                ->constrained('stores')
                ->cascadeOnDelete();
            $table->dropColumn(['module_id', 'category_id', 'zone']);
        });
    }

    public function down(): void
    {
        Schema::table('customer_banners', function (Blueprint $table) {
            $table->dropConstrainedForeignId('store_id');
            $table->unsignedBigInteger('module_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->json('zone')->nullable();
        });
    }
};
