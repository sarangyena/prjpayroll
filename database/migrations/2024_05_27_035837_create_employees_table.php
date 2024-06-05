<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->string('user_name')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable()->default('NULL');
            $table->string('last_name');
            $table->string('role');
            $table->string('email')->nullable()->default('NULL');
            $table->string('phone')->nullable()->default('NULL');
            $table->bigInteger('rate');
            $table->string('status');
            $table->string('job');
            $table->string('sss')->nullable()->default('NULL');
            $table->string('philhealth')->nullable()->default('NULL');
            $table->string('address');
            $table->string('eName')->nullable()->default('NULL');
            $table->string('ePhone')->nullable()->default('NULL');
            $table->string('eAdd')->nullable()->default('NULL');
            $table->string('eStatus')->nullable()->default('ACTIVE');
            $table->string('remarks')->nullable()->default('NULL');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_employee_id FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payslips');
        Schema::dropIfExists('qr_codes');
        Schema::dropIfExists('users');
        Schema::dropIfExists('employees');

    }
};
