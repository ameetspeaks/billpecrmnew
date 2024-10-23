<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('central_libraries', function (Blueprint $table) {
            $table->enum('food_type',['veg', 'non-veg', 'egg'])->after('quantity')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('central_libraries', function (Blueprint $table) {
            $table->dropColumn('food_type');
        });
    }
};
