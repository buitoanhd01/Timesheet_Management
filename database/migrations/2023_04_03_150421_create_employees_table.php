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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->date('birthday');
            $table->string('gender');
            $table->date('start_time');
            $table->date('end_time');
            $table->string('tax_code');
            $table->string('employee_type');
            $table->integer('position_id');
            $table->integer('salary_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
