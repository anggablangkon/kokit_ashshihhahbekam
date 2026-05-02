@extends('layouts.layouts')

@section('title', 'Manajemen Hak Akses')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row my-3">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fs-3 mb-0 fw-bold">Manajemen Hak Akses</h4>
                        <p class="text-muted mb-0">Pilih role, lalu atur menu dan submenu sesuai level role tersebut.</p>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="ti ti-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body py-3">
                    <form action="{{ route('admin.permissions.index') }}" method="GET">
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2">
                            <label class="form-label fw-bold mb-0 text-nowrap">Pilih Role:</label>
                            <select name="role_id" class="form-select shadow-sm" onchange="this.form.submit()" style="max-width: 400px;">
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $selectedRoleId == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($selectedRole)
                                <span class="badge bg-light text-dark border px-3 py-2 text-nowrap">
                                    <i class="ti ti-key text-primary me-1"></i>
                                    {{ count($rolePermissionIds) }} Akses Dipilih
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            @if ($selectedRole)
                <div class="card shadow-sm border-0">
                    <div class="card-header pt-3 pb-2 border-bottom">
                        <h5 class="fw-bold mb-0">
                            Hak Akses untuk: <span class="text-primary">{{ $selectedRole->name }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="permissionForm" action="{{ route('admin.permissions.update', $selectedRole->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="permission-container">
                                <ul class="list-unstyled mb-0">
                                    @foreach ($permissions as $permission)
                                        @php
                                            $hasChildren = $permission->sub_permissions->isNotEmpty();
                                            $checkedParent = in_array($permission->id, $rolePermissionIds);
                                        @endphp
                                        <li class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input parent-check" type="checkbox"
                                                    id="main-{{ $permission->id }}"
                                                    name="permission_ids[]"
                                                    value="{{ $permission->id }}"
                                                    data-parent="{{ $permission->id }}"
                                                    {{ $checkedParent ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold text-dark" for="main-{{ $permission->id }}">
                                                    {{ $permission->display_name }}
                                                </label>
                                            </div>

                                            @if ($hasChildren)
                                                <ul class="list-unstyled ms-4 mt-2">
                                                    @foreach ($permission->sub_permissions as $subPermission)
                                                        <li class="mb-1">
                                                            <div class="form-check">
                                                                <input class="form-check-input child-check child-of-{{ $permission->id }}"
                                                                    type="checkbox"
                                                                    id="sub-{{ $subPermission->id }}"
                                                                    name="permission_sub_ids[]"
                                                                    value="{{ $subPermission->id }}"
                                                                    data-parent="{{ $permission->id }}"
                                                                    {{ in_array($subPermission->id, $roleSubPermissionIds) ? 'checked' : '' }}>
                                                                <label class="form-check-label fw-bold text-secondary" for="sub-{{ $subPermission->id }}">
                                                                    {{ $subPermission->display_name }}
                                                                </label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer d-flex justify-content-start">
                        <button form="permissionForm" type="submit" class="btn btn-primary px-4 shadow-sm fw-bold">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="ti ti-shield-lock fs-1 opacity-25 d-block mb-2"></i>
                    <p class="mb-0">Silakan pilih role pada dropdown di atas untuk mulai mengatur hak akses.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.querySelectorAll('.child-check').forEach(function(childCheckbox) {
            childCheckbox.addEventListener('change', function() {
                const parentId = this.dataset.parent;
                const parentCheckbox = document.querySelector('#main-' + parentId);
                const anyChecked = Array.from(document.querySelectorAll('.child-of-' + parentId)).some(function(item) {
                    return item.checked;
                });

                if (parentCheckbox && anyChecked) {
                    parentCheckbox.checked = true;
                }
            });
        });

        document.querySelectorAll('.parent-check').forEach(function(parentCheckbox) {
            parentCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    return;
                }

                document.querySelectorAll('.child-of-' + this.dataset.parent).forEach(function(childCheckbox) {
                    childCheckbox.checked = false;
                });
            });
        });
    </script>
@endsection
