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
            $table->integer('record_ttlock_id');
            $table->dateTime('time');
            $table->tinyInteger('type');
            $table->integer('staff_id');
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
