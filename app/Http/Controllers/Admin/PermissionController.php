<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminMenu;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $this->ensurePermissionCatalog();

        $roles = Role::query()->orderBy('name')->get();
        $selectedRoleId = $request->integer('role_id');
        $selectedRole = $selectedRoleId ? Role::with('permissions')->find($selectedRoleId) : null;
        $rolePermissionIds = $selectedRole ? $selectedRole->permissions->pluck('id')->all() : [];
        $roleSubPermissionIds = $rolePermissionIds;
        $permissions = $this->menuPermissions();

        return view('admin.permissions.index', compact(
            'roles',
            'selectedRoleId',
            'selectedRole',
            'rolePermissionIds',
            'roleSubPermissionIds',
            'permissions'
        ));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permission_ids' => ['nullable', 'array'],
            'permission_ids.*' => ['integer', 'exists:permissions,id'],
            'permission_sub_ids' => ['nullable', 'array'],
            'permission_sub_ids.*' => ['integer', 'exists:permissions,id'],
        ]);

        $permissionIds = collect($validated['permission_ids'] ?? [])
            ->merge($validated['permission_sub_ids'] ?? [])
            ->unique()
            ->values();

        $role->syncPermissions(Permission::whereIn('id', $permissionIds)->get());
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.permissions.index', ['role_id' => $role->id])
            ->with('success', 'Hak akses berhasil diperbarui.');
    }

    private function ensurePermissionCatalog(): void
    {
        foreach (AdminMenu::permissionNames() as $permissionName) {
            Permission::findOrCreate($permissionName, 'web');
        }
    }

    private function menuPermissions()
    {
        return collect(AdminMenu::permissions())->map(function (array $menu) {
            $permission = Permission::findByName($menu['permission'], 'web');
            $permission->sub_permissions = collect($menu['children'] ?? [])
                ->map(fn (array $child) => Permission::findByName($child['permission'], 'web')->setAttribute('display_name', $child['name']));
            $permission->setAttribute('display_name', $menu['name']);

            return $permission;
        });
    }
}
