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
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->string('pay_id')->unique();
            $table->timestamp('hired');
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('user_name');
            $table->bigInteger('week_id');
            $table->bigInteger('month_id');
            $table->bigInteger('year_id');
            $table->string('name');
            $table->string('job');
            $table->string('pay_period');
            $table->decimal('rate', 8, 2);
            $table->decimal('days', 8, 2)->default(0);
            $table->decimal('late', 8, 2)->default(0);
            $table->decimal('salary', 8, 2)->default(0);
            $table->decimal('rph', 8, 2);
            $table->decimal('hrs', 8, 2)->default(0);
            $table->decimal('otpay', 8, 2)->default(0);
            $table->decimal('holiday', 8, 2)->default(0);
            $table->decimal('philhealth', 8, 2)->default(0);
            $table->decimal('sss', 8, 2)->default(0);
            $table->decimal('advance', 8, 2)->default(0);
            $table->decimal('gross', 8, 2)->default(0);
            $table->decimal('deduction', 8, 2)->default(0);
            $table->decimal('net', 8, 2)->default(0);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};
