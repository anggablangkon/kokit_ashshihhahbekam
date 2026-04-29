<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's admin account.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@btech.com'],
            [
                'name' => 'Admin Btech',
                'password' => 'admin123',
                'email_verified_at' => now(),
            ]
        );
    }
}
