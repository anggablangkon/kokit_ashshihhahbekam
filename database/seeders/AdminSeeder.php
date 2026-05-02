<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\AdminMenu;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's admin account.
     */
    public function run(): void
    {
        foreach (AdminMenu::permissionNames() as $permissionName) {
            Permission::findOrCreate($permissionName, 'web');
        }

        $superAdmin = Role::findOrCreate('Super Admin', 'web');
        Role::findOrCreate('Pegawai', 'web');
        $superAdmin->syncPermissions(Permission::whereIn('name', AdminMenu::permissionNames())->get());

        User::updateOrCreate(
            ['email' => 'admin@btech.com'],
            [
                'name' => 'Admin Btech',
                'password' => 'admin123',
                'email_verified_at' => now(),
            ]
        )->assignRole($superAdmin);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
