<?php

use App\Models\User;
use App\Support\AdminMenu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $permissions = $this->permissions();

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permission, 'guard_name' => 'web'],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }

        DB::table('roles')->updateOrInsert(
            ['name' => 'Super Admin', 'guard_name' => 'web'],
            ['created_at' => $now, 'updated_at' => $now]
        );

        DB::table('roles')->updateOrInsert(
            ['name' => 'Pegawai', 'guard_name' => 'web'],
            ['created_at' => $now, 'updated_at' => $now]
        );

        $superAdminId = DB::table('roles')->where('name', 'Super Admin')->value('id');
        $permissionIds = DB::table('permissions')->whereIn('name', $permissions)->pluck('id');

        foreach ($permissionIds as $permissionId) {
            DB::table('role_has_permissions')->updateOrInsert([
                'role_id' => $superAdminId,
                'permission_id' => $permissionId,
            ]);
        }

        DB::table('users')->orderBy('id')->chunkById(100, function ($users) use ($superAdminId) {
            foreach ($users as $user) {
                DB::table('model_has_roles')->updateOrInsert([
                    'role_id' => $superAdminId,
                    'model_type' => User::class,
                    'model_id' => $user->id,
                ]);
            }
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        DB::table('role_has_permissions')->whereIn('permission_id', function ($query) {
            $query->select('id')->from('permissions')->whereIn('name', $this->permissions());
        })->delete();

        DB::table('permissions')->whereIn('name', $this->permissions())->delete();
        DB::table('roles')->whereIn('name', ['Super Admin', 'Pegawai'])->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function permissions(): array
    {
        return AdminMenu::permissionNames();
    }
};
