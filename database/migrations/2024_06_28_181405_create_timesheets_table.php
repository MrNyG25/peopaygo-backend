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
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();

            $table->integer('amount')->nullable();
            $table->text('note')->nullable();

            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')
                    ->references('id')
                    ->on('employees');

            $table->unsignedBigInteger('timesheet_status_id');
            $table->foreign('timesheet_status_id')
                    ->references('id')
                    ->on('timesheet_statuses');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
