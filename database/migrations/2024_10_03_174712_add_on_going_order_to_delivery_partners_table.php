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
        Schema::table('delivery_partners', function (Blueprint $table) {
            $table->tinyInteger('on_going_order')->default(0)->after('longitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_partners', function (Blueprint $table) {
            $table->dropColumn('on_going_order');
        });
    }
};
