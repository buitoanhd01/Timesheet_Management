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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_ip')->nullable();
            $table->string('password_default')->nullable()->default('DGT@2023');
            $table->string('minutes_delay_checkout')->nullable();
            $table->time('time_start_work')->nullable();
            $table->time('time_end_work')->nullable();
            $table->time('time_start_lunch')->nullable();
            $table->time('time_end_lunch')->nullable();
            $table->time('time_start_overtime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
