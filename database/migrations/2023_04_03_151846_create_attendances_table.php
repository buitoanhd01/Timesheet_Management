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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer('employee_id');
            $table->dateTime('first_checkin')->nullable();
            $table->dateTime('last_checkout')->nullable();
            $table->float('working_hours')->nullable();
            $table->float('overtime')->nullable();
            $table->boolean('status')->default(0)->comment('0: Late ,1: Early, 2: Late/early');
            $table->string('notes', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
