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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('store_id')->nullable();
            $table->string('name');
            $table->string('vender_for')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('whatsapp_no')->nullable();
            $table->string('role_type');
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('label')->nullable();
            $table->string('locality')->nullable();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('notes')->nullable();
            $table->string('image')->nullable();
            $table->string('aadhar_number')->nullable();
            $table->string('driving_licence')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('status')->nullable();
            $table->text('device_token')->nullable();
            $table->text('referral_code')->nullable();
            $table->string('total_wallet_amount')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
