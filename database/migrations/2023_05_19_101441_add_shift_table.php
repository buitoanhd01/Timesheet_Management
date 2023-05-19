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
        Schema::create('Shifts', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->string('shift_name')->nullable();
            $table->time('shift_start_time')->nullable();
            $table->time('shift_end_time')->nullable();
            $table->time('shift_rest_time_start')->nullable();
            $table->time('shift_rest_time_end')->nullable();
            $table->time('time_start_overtime')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Shifts');
    }
};
