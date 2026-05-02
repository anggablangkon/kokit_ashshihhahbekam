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

    <div class="col-12 mb-3">
        <label for="{{ $fieldPrefix }}_thumbnail" class="form-label">
            Thumbnail
            @if (!$currentTreatment)
                <span class="text-danger">*</span>
            @endif
        </label>
        <input
            type="file"
            id="{{ $fieldPrefix }}_thumbnail"
            name="thumbnail"
            class="form-control {{ $usesOldInput && $errors->has('thumbnail') ? 'is-invalid' : '' }}"
            accept="image/png,image/jpeg,image/webp"
            onchange="treatmentPreviewPhoto(this, '{{ $fieldPrefix }}')"
        >
        @if ($usesOldInput && $errors->has('thumbnail'))
            <div class="invalid-feedback d-block">{{ $errors->first('thumbnail') }}</div>
        @endif

        {{-- Preview Area --}}
        <div id="{{ $fieldPrefix }}_thumb_preview_wrapper"
            class="mt-2 {{ $currentTreatment?->thumbnail ? '' : 'd-none' }}">
            <div class="d-flex align-items-center gap-3 p-2 border rounded bg-light">
                <img
                    id="{{ $fieldPrefix }}_thumb_preview"
                    src="{{ $currentTreatment?->thumbnail ? \Illuminate\Support\Facades\Storage::url($currentTreatment->thumbnail) : '' }}"
                    alt="Preview thumbnail"
                    class="rounded border"
                    width="80" height="60"
                    style="object-fit: cover; flex-shrink: 0; cursor: zoom-in;"
                    data-photo-src="{{ $currentTreatment?->thumbnail ? \Illuminate\Support\Facades\Storage::url($currentTreatment->thumbnail) : '' }}"
                    data-photo-name="{{ $currentTreatment?->treatment_name ?? 'Thumbnail' }}"
                    onclick="treatmentZoomPreview(this)">
                <div class="flex-grow-1 overflow-hidden">
                    <div id="{{ $fieldPrefix }}_thumb_name" class="small fw-semibold text-truncate">
                        {{ $currentTreatment?->thumbnail ? basename($currentTreatment->thumbnail) : '' }}
                    </div>
                    <div class="small text-muted">Thumbnail treatment</div>
                </div>
                <button type="button"
                    class="btn btn-sm btn-outline-danger rounded-circle p-1 lh-1"
                    onclick="treatmentClearPhoto('{{ $fieldPrefix }}')"
                    title="Hapus pilihan">
                    <i class="ti ti-x" style="font-size: 12px;"></i>
                </button>
            </div>
        </div>
    </div>
</div>