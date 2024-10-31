<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('central_libraries', function (Blueprint $table) {
            $table->text('short_description')->nullable();
            $table->json('multiple_images')->nullable();
            $table->date('manufacture_date')->nullable();
            $table->date('expiry_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('central_libraries', function (Blueprint $table) {
            $table->dropColumn('short_description');
            $table->dropColumn('multiple_images');
            $table->dropColumn('manufacture_date');
            $table->dropColumn('expiry_date');
        });
    }
};
