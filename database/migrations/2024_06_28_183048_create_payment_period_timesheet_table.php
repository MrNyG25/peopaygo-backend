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
        Schema::create('payment_period_timesheet', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('payment_period_id');
            $table->foreign('payment_period_id')
                    ->references('id')
                    ->on('payment_periods');

            $table->unsignedBigInteger('timesheet_id');
            $table->foreign('timesheet_id')
                    ->references('id')
                    ->on('timesheets');

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_period_timesheet');
    }
};
