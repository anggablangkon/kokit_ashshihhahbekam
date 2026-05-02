@php
    $currentEmployee = $employee ?? null;
    $currentFormContext = $formContext ?? null;
    $usesOldInput = $currentFormContext !== null && old('form_context') === $currentFormContext;
    $fieldPrefix = $fieldPrefix ?? 'employee';
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_name" class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
        <input type="text" id="{{ $fieldPrefix }}_name" name="name"
            class="form-control {{ $usesOldInput && $errors->has('name') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('name') : ($currentEmployee?->name ?? '') }}"
            placeholder="Masukkan nama pegawai">
        @if ($usesOldInput && $errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_email" class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" id="{{ $fieldPrefix }}_email" name="email"
            class="form-control {{ $usesOldInput && $errors->has('email') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('email') : ($currentEmployee?->email ?? '') }}"
            placeholder="nama@email.com">
        @if ($usesOldInput && $errors->has('email'))
            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_password" class="form-label">
            Password @if (!$currentEmployee) <span class="text-danger">*</span> @endif
        </label>
        <input type="password" id="{{ $fieldPrefix }}_password" name="password"
            class="form-control {{ $usesOldInput && $errors->has('password') ? 'is-invalid' : '' }}"
            placeholder="{{ $currentEmployee ? 'Kosongkan jika tidak diubah' : 'Masukkan password' }}">
        @if ($usesOldInput && $errors->has('password'))
            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_password_confirmation" class="form-label">
            Konfirmasi Password @if (!$currentEmployee) <span class="text-danger">*</span> @endif
        </label>
        <input type="password" id="{{ $fieldPrefix }}_password_confirmation" name="password_confirmation"
            class="form-control"
            placeholder="{{ $currentEmployee ? 'Kosongkan jika tidak diubah' : 'Ulangi password' }}">
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_role_id" class="form-label">Role <span class="text-danger">*</span></label>
        <select id="{{ $fieldPrefix }}_role_id" name="role_id"
            class="form-select {{ $usesOldInput && $errors->has('role_id') ? 'is-invalid' : '' }}">
            <option value="" disabled {{ ($usesOldInput ? old('role_id') : $currentEmployee?->roles->first()?->id) ? '' : 'selected' }}>
                -- Pilih Role --
            </option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}"
                    @selected(($usesOldInput ? old('role_id') : $currentEmployee?->roles->first()?->id) == $role->id)>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        @if ($usesOldInput && $errors->has('role_id'))
            <div class="invalid-feedback">{{ $errors->first('role_id') }}</div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_profile_photo" class="form-label">Foto Profil</label>
        <input type="file" id="{{ $fieldPrefix }}_profile_photo" name="profile_photo"
            class="form-control {{ $usesOldInput && $errors->has('profile_photo') ? 'is-invalid' : '' }}"
            accept="image/png,image/jpeg,image/webp"
            onchange="previewPhoto(this, '{{ $fieldPrefix }}_photo_preview')">
        @if ($usesOldInput && $errors->has('profile_photo'))
            <div class="invalid-feedback">{{ $errors->first('profile_photo') }}</div>
        @endif

        {{-- Preview Area --}}
        <div id="{{ $fieldPrefix }}_photo_preview_wrapper" class="mt-2 {{ $currentEmployee?->profile_photo ? '' : 'd-none' }}">
            <div class="d-flex align-items-center gap-2 p-2 border rounded bg-light">
                <img id="{{ $fieldPrefix }}_photo_preview"
                    src="{{ $currentEmployee?->profile_photo ? Storage::url($currentEmployee->profile_photo) : '' }}"
                    alt="Preview foto"
                    class="rounded-circle"
                    width="48" height="48"
                    style="object-fit: cover; flex-shrink: 0;">
                <div class="flex-grow-1 overflow-hidden">
                    <div id="{{ $fieldPrefix }}_photo_name" class="small fw-semibold text-truncate">
                        {{ $currentEmployee?->profile_photo ? basename($currentEmployee->profile_photo) : '' }}
                    </div>
                    <div class="small text-muted">Foto profil</div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-1 lh-1"
                    onclick="clearPhoto('{{ $fieldPrefix }}_profile_photo', '{{ $fieldPrefix }}_photo_preview', '{{ $fieldPrefix }}_photo_preview_wrapper')"
                    title="Hapus pilihan">
                    <i class="ti ti-x" style="font-size: 12px;"></i>
                </button>
            </div>
        </div>
    </div>
</div>