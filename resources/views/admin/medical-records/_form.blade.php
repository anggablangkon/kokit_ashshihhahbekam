@php
    $currentMedicalRecord = $medicalRecord ?? null;
    $currentFormContext = $formContext ?? null;
    $usesOldInput = $currentFormContext !== null && old('form_context') === $currentFormContext;
    $fieldPrefix = $fieldPrefix ?? 'medical_record';
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_patient_id" class="form-label">Pasien <span class="text-danger">*</span></label>
        <select id="{{ $fieldPrefix }}_patient_id" name="patient_id" class="form-select {{ $usesOldInput && $errors->has('patient_id') ? 'is-invalid' : '' }}">
            <option value="">Pilih pasien</option>
            @foreach ($patients as $patientOption)
                <option value="{{ $patientOption->id }}" @selected(($usesOldInput ? old('patient_id') : $currentMedicalRecord?->patient_id) == $patientOption->id)>
                    {{ $patientOption->name }}
                </option>
            @endforeach
        </select>
        @if ($usesOldInput && $errors->has('patient_id'))
            <div class="invalid-feedback">{{ $errors->first('patient_id') }}</div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_employee_id" class="form-label">Pegawai <span class="text-danger">*</span></label>
        <select id="{{ $fieldPrefix }}_employee_id" name="employee_id" class="form-select {{ $usesOldInput && $errors->has('employee_id') ? 'is-invalid' : '' }}">
            <option value="">Pilih pegawai</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}" @selected(($usesOldInput ? old('employee_id') : $currentMedicalRecord?->employee_id) == $employee->id)>
                    {{ $employee->name }}
                </option>
            @endforeach
        </select>
        @if ($usesOldInput && $errors->has('employee_id'))
            <div class="invalid-feedback">{{ $errors->first('employee_id') }}</div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_treatment_date" class="form-label">Tanggal Treatment <span class="text-danger">*</span></label>
        <input
            type="date"
            id="{{ $fieldPrefix }}_treatment_date"
            name="treatment_date"
            class="form-control {{ $usesOldInput && $errors->has('treatment_date') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('treatment_date') : ($currentMedicalRecord?->treatment_date?->format('Y-m-d') ?? '') }}"
        >
        @if ($usesOldInput && $errors->has('treatment_date'))
            <div class="invalid-feedback">{{ $errors->first('treatment_date') }}</div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_total_cost" class="form-label">Total Biaya <span class="text-danger">*</span></label>
        <input
            type="text"
            inputmode="numeric"
            id="{{ $fieldPrefix }}_total_cost"
            name="total_cost"
            class="form-control js-currency-input {{ $usesOldInput && $errors->has('total_cost') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('total_cost') : ($currentMedicalRecord ? number_format((float) $currentMedicalRecord->total_cost, 0, ',', '.') : '') }}"
            placeholder="0"
        >
        @if ($usesOldInput && $errors->has('total_cost'))
            <div class="invalid-feedback">{{ $errors->first('total_cost') }}</div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_complaint" class="form-label">Keluhan <span class="text-danger">*</span></label>
        <textarea
            id="{{ $fieldPrefix }}_complaint"
            name="complaint"
            rows="5"
            class="form-control {{ $usesOldInput && $errors->has('complaint') ? 'is-invalid' : '' }}"
            placeholder="Tuliskan keluhan pasien"
        >{{ $usesOldInput ? old('complaint') : ($currentMedicalRecord?->complaint ?? '') }}</textarea>
        @if ($usesOldInput && $errors->has('complaint'))
            <div class="invalid-feedback">{{ $errors->first('complaint') }}</div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_action_details" class="form-label">Tindakan <span class="text-danger">*</span></label>
        <textarea
            id="{{ $fieldPrefix }}_action_details"
            name="action_details"
            rows="5"
            class="form-control {{ $usesOldInput && $errors->has('action_details') ? 'is-invalid' : '' }}"
            placeholder="Tuliskan tindakan yang dilakukan"
        >{{ $usesOldInput ? old('action_details') : ($currentMedicalRecord?->action_details ?? '') }}</textarea>
        @if ($usesOldInput && $errors->has('action_details'))
            <div class="invalid-feedback">{{ $errors->first('action_details') }}</div>
        @endif
    </div>
</div>
