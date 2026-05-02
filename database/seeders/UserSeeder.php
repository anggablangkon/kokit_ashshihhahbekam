<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::findOrCreate('Super Admin', 'web');
        Role::findOrCreate('Pegawai', 'web');

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@btech.com',
            'password' => Hash::make('admin123'), 
        ])->assignRole($superAdmin);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('Pegawai');
    }
}
