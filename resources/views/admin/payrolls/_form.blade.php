@php
    $currentPayroll = $payroll ?? null;
    $currentFormContext = $formContext ?? null;
    $usesOldInput = $currentFormContext !== null && old('form_context') === $currentFormContext;
    $fieldPrefix = $fieldPrefix ?? 'payroll';
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_employee_id" class="form-label">Pegawai <span class="text-danger">*</span></label>
        <select id="{{ $fieldPrefix }}_employee_id" name="employee_id" class="form-select {{ $usesOldInput && $errors->has('employee_id') ? 'is-invalid' : '' }}">
            <option value="">Pilih pegawai</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}" @selected(($usesOldInput ? old('employee_id') : $currentPayroll?->employee_id) == $employee->id)>
                    {{ $employee->name }}
                </option>
            @endforeach
        </select>
        @if ($usesOldInput && $errors->has('employee_id'))
            <div class="invalid-feedback">{{ $errors->first('employee_id') }}</div>
        @endif
    </div>

    <div class="col-md-3 mb-3">
        <label for="{{ $fieldPrefix }}_period_month" class="form-label">Bulan <span class="text-danger">*</span></label>
        <select id="{{ $fieldPrefix }}_period_month" name="period_month" class="form-select {{ $usesOldInput && $errors->has('period_month') ? 'is-invalid' : '' }}">
            <option value="">Pilih bulan</option>
            @foreach ($monthOptions as $value => $label)
                <option value="{{ $value }}" @selected(($usesOldInput ? old('period_month') : $currentPayroll?->period_month) == $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @if ($usesOldInput && $errors->has('period_month'))
            <div class="invalid-feedback">{{ $errors->first('period_month') }}</div>
        @endif
    </div>

    <div class="col-md-3 mb-3">
        <label for="{{ $fieldPrefix }}_period_year" class="form-label">Tahun <span class="text-danger">*</span></label>
        <input
            type="text"
            inputmode="numeric"
            id="{{ $fieldPrefix }}_period_year"
            name="period_year"
            class="form-control {{ $usesOldInput && $errors->has('period_year') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('period_year') : ($currentPayroll?->period_year ?? date('Y')) }}"
        >
        @if ($usesOldInput && $errors->has('period_year'))
            <div class="invalid-feedback">{{ $errors->first('period_year') }}</div>
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label for="{{ $fieldPrefix }}_basic_salary" class="form-label">Gaji Pokok <span class="text-danger">*</span></label>
        <input
            type="text"
            inputmode="numeric"
            id="{{ $fieldPrefix }}_basic_salary"
            name="basic_salary"
            class="form-control js-currency-input js-payroll-basic {{ $usesOldInput && $errors->has('basic_salary') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('basic_salary') : ($currentPayroll ? number_format((float) $currentPayroll->basic_salary, 0, ',', '.') : '') }}"
        >
        @if ($usesOldInput && $errors->has('basic_salary'))
            <div class="invalid-feedback">{{ $errors->first('basic_salary') }}</div>
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label for="{{ $fieldPrefix }}_total_commission" class="form-label">Total Komisi</label>
        <input
            type="text"
            inputmode="numeric"
            id="{{ $fieldPrefix }}_total_commission"
            name="total_commission"
            class="form-control js-currency-input js-payroll-commission {{ $usesOldInput && $errors->has('total_commission') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('total_commission') : ($currentPayroll ? number_format((float) $currentPayroll->total_commission, 0, ',', '.') : '0') }}"
        >
        @if ($usesOldInput && $errors->has('total_commission'))
            <div class="invalid-feedback">{{ $errors->first('total_commission') }}</div>
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label for="{{ $fieldPrefix }}_grand_total_preview" class="form-label">Grand Total</label>
        <input
            type="text"
            id="{{ $fieldPrefix }}_grand_total_preview"
            class="form-control js-payroll-total-preview"
            value="Rp 0"
            readonly
        >
        <div class="form-text">Nilai ini dihitung otomatis dari gaji pokok + total komisi.</div>
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_status" class="form-label">Status <span class="text-danger">*</span></label>
        <select id="{{ $fieldPrefix }}_status" name="status" class="form-select js-payroll-status {{ $usesOldInput && $errors->has('status') ? 'is-invalid' : '' }}">
            <option value="">Pilih status</option>
            <option value="pending" @selected(($usesOldInput ? old('status') : ($currentPayroll?->status ?? 'pending')) === 'pending')>Pending</option>
            <option value="paid" @selected(($usesOldInput ? old('status') : $currentPayroll?->status) === 'paid')>Paid</option>
        </select>
        @if ($usesOldInput && $errors->has('status'))
            <div class="invalid-feedback">{{ $errors->first('status') }}</div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="{{ $fieldPrefix }}_payment_date" class="form-label">Tanggal Pembayaran</label>
        <input
            type="date"
            id="{{ $fieldPrefix }}_payment_date"
            name="payment_date"
            class="form-control js-payroll-payment-date {{ $usesOldInput && $errors->has('payment_date') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('payment_date') : ($currentPayroll?->payment_date?->format('Y-m-d') ?? '') }}"
        >
        @if ($usesOldInput && $errors->has('payment_date'))
            <div class="invalid-feedback">{{ $errors->first('payment_date') }}</div>
        @endif
    </div>
</div>
