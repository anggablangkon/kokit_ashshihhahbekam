@php
    $currentPatient = $patient ?? null;
    $currentFormContext = $formContext ?? null;
    $usesOldInput = $currentFormContext !== null && old('form_context') === $currentFormContext;
    $fieldPrefix = $fieldPrefix ?? 'patient';
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_name" class="form-label">Nama Pasien <span class="text-danger">*</span></label>
        <input
            type="text"
            id="{{ $fieldPrefix }}_name"
            name="name"
            class="form-control {{ $usesOldInput && $errors->has('name') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('name') : ($currentPatient?->name ?? '') }}"
            placeholder="Masukkan nama pasien"
        >
        @if ($usesOldInput && $errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
        <input
            type="text"
            id="{{ $fieldPrefix }}_phone"
            name="phone"
            class="form-control {{ $usesOldInput && $errors->has('phone') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('phone') : ($currentPatient?->phone ?? '') }}"
            placeholder="Contoh: 081234567890"
        >
        @if ($usesOldInput && $errors->has('phone'))
            <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_birth_date" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
        <input
            type="date"
            id="{{ $fieldPrefix }}_birth_date"
            name="birth_date"
            class="form-control {{ $usesOldInput && $errors->has('birth_date') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('birth_date') : ($currentPatient?->birth_date?->format('Y-m-d') ?? '') }}"
        >
        @if ($usesOldInput && $errors->has('birth_date'))
            <div class="invalid-feedback">{{ $errors->first('birth_date') }}</div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Informasi</label>
        <div class="border rounded p-3 bg-light-subtle h-100">
            <p class="mb-1 fw-semibold">Catatan</p>
            <p class="mb-0 text-muted">Data pasien akan dipakai pada modul rekam medis. Pastikan nama dan nomor telepon terisi benar.</p>
        </div>
    </div>

    <div class="col-12 mb-3">
        <label for="{{ $fieldPrefix }}_address" class="form-label">Alamat</label>
        <textarea
            id="{{ $fieldPrefix }}_address"
            name="address"
            rows="4"
            class="form-control {{ $usesOldInput && $errors->has('address') ? 'is-invalid' : '' }}"
            placeholder="Masukkan alamat lengkap pasien"
        >{{ $usesOldInput ? old('address') : ($currentPatient?->address ?? '') }}</textarea>
        @if ($usesOldInput && $errors->has('address'))
            <div class="invalid-feedback">{{ $errors->first('address') }}</div>
        @endif
    </div>
</div>
