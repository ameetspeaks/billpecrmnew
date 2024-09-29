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
        Schema::create('delivery_partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->integer('work_shift_id')->default(0);
            $table->string('aadhar_front_img')->nullable();
            $table->string('aadhar_back_img')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('pan_front_img')->nullable();
            $table->string('dl_front_img')->nullable();
            $table->string('dl_back_img')->nullable();
            $table->string('rc_number')->nullable();
            $table->string('rc_front_img')->nullable();
            $table->string('rc_back_img')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc')->nullable();
            $table->tinyInteger('current_work_status')->default(0)->comment('0=Offline, 1=Online');
            $table->string('account_status', 20)->default("Pending")->comment('Possible values: Pending, Approved, Rejected');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_partners');
    }
};
