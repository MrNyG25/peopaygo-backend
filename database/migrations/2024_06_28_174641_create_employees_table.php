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

            $table->string('name');

            $table->integer('pay_rate');

            $table->unsignedBigInteger('payment_type_id');
            $table->foreign('payment_type_id')
                    ->references('id')
                    ->on('payment_types');

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')
                    ->references('id')
                    ->on('customers');

            $table->timestamps();
            $table->softDeletes();
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
