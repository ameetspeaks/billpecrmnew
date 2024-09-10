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
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('store_id')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('facebook_followers')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('instagram_followers')->nullable();
            $table->string('youTube_link')->nullable();
            $table->string('website_link')->nullable();
            $table->string('app_link')->nullable();
            $table->string('google_review_link')->nullable();
            $table->string('kirana_club_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};
