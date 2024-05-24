<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'userName' => 'admin',
            'userType' => 'ADMIN',
        ]);
        User::factory()->create([
            'userName' => 'user',
            'userType' => 'USER',
        ]);
        User::factory()->create([
            'userName' => 'qr',
            'userType' => 'QR',
        ]);
    }
}
