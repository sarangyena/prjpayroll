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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('pay_id')->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('employee_id')->references('id')->on('employees')->cascadeOnDelete();
            $table->string('userName')->nullable();
            $table->bigInteger('week_id')->nullable();
            $table->bigInteger('month_id')->nullable();
            $table->bigInteger('year_id')->nullable();
            $table->string('week')->nullable();
            $table->string('name')->nullable();
            $table->string('job')->nullable();
            $table->decimal('rate', 8, 2)->nullable();
            $table->decimal('days', 8, 2)->nullable()->default(0);
            $table->decimal('late', 8, 2)->nullable()->default(0);
            $table->decimal('salary', 8, 2)->nullable()->default(0);
            $table->decimal('rph', 8, 2)->nullable();
            $table->decimal('hrs', 8, 2)->nullable()->default(0);
            $table->decimal('otpay', 8, 2)->nullable()->default(0);
            $table->decimal('holiday', 8, 2)->nullable()->default(0);
            $table->decimal('philhealth', 8, 2)->nullable()->default(0);
            $table->decimal('sss', 8, 2)->nullable()->default(0);
            $table->decimal('advance', 8, 2)->nullable()->default(0);
            $table->decimal('gross', 8, 2)->nullable()->default(0);
            $table->decimal('deduction', 8, 2)->nullable()->default(0);
            $table->decimal('net', 8, 2)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
