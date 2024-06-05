<?php

namespace Database\Factories;

use App\Http\Controllers\FunctionController;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $role = 'EMPLOYEE';
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'sss' => $this->faker->randomNumber(),
            'philhealth' => $this->faker->randomNumber(),
            'address' => $this->faker->address,
        ];
    }
}
