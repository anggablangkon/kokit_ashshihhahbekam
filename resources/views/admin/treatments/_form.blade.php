@php
    $currentTreatment = $treatment ?? null;
    $currentFormContext = $formContext ?? null;
    $usesOldInput = $currentFormContext !== null && old('form_context') === $currentFormContext;
    $fieldPrefix = $fieldPrefix ?? 'treatment';
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_treatment_name" class="form-label">Nama Treatment <span class="text-danger">*</span></label>
        <input
            type="text"
            id="{{ $fieldPrefix }}_treatment_name"
            name="treatment_name"
            class="form-control {{ $usesOldInput && $errors->has('treatment_name') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('treatment_name') : ($currentTreatment?->treatment_name ?? '') }}"
            placeholder="Masukkan nama treatment"
        >
        @if ($usesOldInput && $errors->has('treatment_name'))
            <div class="invalid-feedback">{{ $errors->first('treatment_name') }}</div>
        @endif
    </div>

    <div class="col-md-3 mb-3">
        <label for="{{ $fieldPrefix }}_price" class="form-label">Harga <span class="text-danger">*</span></label>
        <input
            type="text"
            inputmode="numeric"
            id="{{ $fieldPrefix }}_price"
            name="price"
            class="form-control js-currency-input {{ $usesOldInput && $errors->has('price') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('price') : ($currentTreatment ? number_format((float) $currentTreatment->price, 0, ',', '.') : '') }}"
            placeholder="0"
        >
        @if ($usesOldInput && $errors->has('price'))
            <div class="invalid-feedback">{{ $errors->first('price') }}</div>
        @endif
    </div>

    <div class="col-md-3 mb-3">
        <label for="{{ $fieldPrefix }}_employee_commission" class="form-label">Komisi Pegawai <span class="text-danger">*</span></label>
        <input
            type="text"
            inputmode="numeric"
            id="{{ $fieldPrefix }}_employee_commission"
            name="employee_commission"
            class="form-control js-currency-input {{ $usesOldInput && $errors->has('employee_commission') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('employee_commission') : ($currentTreatment ? number_format((float) $currentTreatment->employee_commission, 0, ',', '.') : '') }}"
            placeholder="0"
        >
        @if ($usesOldInput && $errors->has('employee_commission'))
            <div class="invalid-feedback">{{ $errors->first('employee_commission') }}</div>
        @endif
    </div>

    <div class="col-12 mb-3">
        <label for="{{ $fieldPrefix }}_description" class="form-label">Deskripsi</label>
        <textarea
            id="{{ $fieldPrefix }}_description"
            name="description"
            rows="5"
            class="form-control {{ $usesOldInput && $errors->has('description') ? 'is-invalid' : '' }}"
            placeholder="Tuliskan deskripsi treatment"
        >{{ $usesOldInput ? old('description') : ($currentTreatment?->description ?? '') }}</textarea>
        @if ($usesOldInput && $errors->has('description'))
            <div class="invalid-feedback">{{ $errors->first('description') }}</div>
        @endif
    </div>
</div>
