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
        Schema::create('history_inouts', function (Blueprint $table) {
            $table->id();
            $table->integer('record_ttlock_id')->nullable();
            $table->dateTime('time')->nullable();
            $table->boolean('type', 1)->nullable();
            $table->integer('employee_id',10)->autoIncrement(FALSE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_inouts');
    }
};
