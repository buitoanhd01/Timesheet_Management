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
        Schema::create('salary', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->date('month')->nullable();
            $table->year('year')->nullable();
            $table->float('overtime')->nullable();
            $table->string('leave_days')->nullable();
            $table->double('total_salary')->nullable();
            $table->double('bonus')->nullable();
            $table->double('basic_salary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary');
    }
};
