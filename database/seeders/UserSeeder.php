<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Pusat',
            'email' => 'admin@sbi.com',
            'password' => Hash::make('!@#Rahasia'), // password: password123
        ]);

        User::create([
            'name' => 'Angga Blangkon',
            'email' => 'anggakurniawan135@gmail.com',
            'password' => Hash::make('password'), // password: user123
        ]);
    }
}
