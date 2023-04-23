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
        Schema::create('working_modes', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->time('working_start')->nullable();
            $table->time('working_end')->nullable();
            $table->integer('paid_leaves')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('working_modes');
    }
};
