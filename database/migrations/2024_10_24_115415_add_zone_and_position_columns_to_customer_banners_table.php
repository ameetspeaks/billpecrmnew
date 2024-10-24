<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customer_banners', function (Blueprint $table) {
            $table->enum('position', ['top', 'bottom'])->default('top');
            $table->json('zone')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('customer_banners', function (Blueprint $table) {
            $table->dropColumn(['position', 'zone']);
        });
    }
};
