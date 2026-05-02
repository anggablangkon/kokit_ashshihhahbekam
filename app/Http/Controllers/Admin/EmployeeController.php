<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEmployeeRequest;
use App\Http\Requests\Admin\UpdateEmployeeRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::query()
            ->with('roles')
            ->latest()
            ->get();

        $roles = Role::query()
            ->orderBy('name')
            ->get();

        return view('admin.employees.index', compact('employees', 'roles'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $payload = $request->safe()->except(['profile_photo', 'role_id']);

        if ($request->hasFile('profile_photo')) {
            $payload['profile_photo'] = $request->file('profile_photo')->store('users', 'public');
        }

        $employee = User::create($payload);
        $this->syncRole($employee, $request->validated('role_id'));

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function update(UpdateEmployeeRequest $request, User $employee)
    {
        $payload = $request->safe()->except(['profile_photo', 'role_id', 'password']);

        if ($request->filled('password')) {
            $payload['password'] = $request->validated('password');
        }

        if ($request->hasFile('profile_photo')) {
            $this->deletePhoto($employee->profile_photo);
            $payload['profile_photo'] = $request->file('profile_photo')->store('users', 'public');
        }

        $employee->update($payload);
        $this->syncRole($employee, $request->validated('role_id'));

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(User $employee)
    {
        if ($employee->is(auth()->user())) {
            return back()->with('error', 'Akun yang sedang digunakan tidak bisa dihapus.');
        }

        $this->deletePhoto($employee->profile_photo);
        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }

    private function syncRole(User $employee, mixed $roleId): void
    {
        if (!$roleId) {
            $employee->syncRoles([]);
            return;
        }

        $role = Role::findById((int) $roleId, 'web');
        $employee->syncRoles([$role]);
    }

    private function deletePhoto(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
