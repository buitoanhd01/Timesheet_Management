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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id',10)->autoIncrement(FALSE);
            $table->dateTime('leave_date_start')->nullable();
            $table->dateTime('leave_date_end')->nullable();
            $table->boolean('leave_type', 1)->nullable();
            $table->text('reason')->nullable();
            $table->dateTime('time_sent_request')->nullable();
            $table->dateTime('time_response_request')->nullable();
            $table->boolean('status', 1)->default(0);
            $table->string('responded_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
