<?php

namespace Database\Seeders;

use App\Http\Controllers\FunctionController;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = 'EMPLOYEE';
        Employee::factory()->state([
            'user_name'=>FunctionController::username2($role),
            'eStatus' => 'ACTIVE',
        ])->create();
    }
}
