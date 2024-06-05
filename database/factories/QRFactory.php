<?php

namespace Database\Factories;

use App\Http\Controllers\FunctionController;
use App\QR;  // Replace with your actual QR model namespace
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QR>
 */
class QRFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_name'=>FunctionController::username1(),
        ];
    }
}
