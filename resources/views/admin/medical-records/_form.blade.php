@php
    $currentMedicalRecord = $medicalRecord ?? null;
    $currentFormContext = $formContext ?? null;
    $usesOldInput = $currentFormContext !== null && old('form_context') === $currentFormContext;
    $fieldPrefix = $fieldPrefix ?? 'medical_record';
    $selectedPatientId = $usesOldInput ? old('patient_id') : $currentMedicalRecord?->patient_id;
    $selectedEmployeeId = $usesOldInput ? old('employee_id') : $currentMedicalRecord?->employee_id;
    $initialItems = collect();

    if ($usesOldInput) {
        $initialItems = collect(old('treatments', []))->values();
    } elseif ($currentMedicalRecord) {
        $initialItems = $currentMedicalRecord->items->map(fn ($item) => [
            'name' => $item->treatment_name,
            'qty' => $item->qty,
            'price' => $item->price,
            'discount' => $item->discount,
        ]);
    }
@endphp

<div class="row js-medical-record-form">
    <div class="col-md-4 mb-3">
        <label for="{{ $fieldPrefix }}_patient_id" class="form-label">Pasien <span class="text-danger">*</span></label>
        <select id="{{ $fieldPrefix }}_patient_id" name="patient_id" class="form-select js-patient-select {{ $usesOldInput && $errors->has('patient_id') ? 'is-invalid' : '' }}" data-placeholder="Cari nama atau no HP pasien">
            <option value="">Pilih pasien</option>
            @foreach ($patients as $patientOption)
                <option value="{{ $patientOption->id }}" data-phone="{{ $patientOption->phone }}" @selected($selectedPatientId == $patientOption->id)>
                    {{ $patientOption->name }}{{ $patientOption->phone ? ' - ' . $patientOption->phone : '' }}
                </option>
            @endforeach
        </select>
        @if ($usesOldInput && $errors->has('patient_id'))
            <div class="invalid-feedback d-block">{{ $errors->first('patient_id') }}</div>
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label for="{{ $fieldPrefix }}_employee_id" class="form-label">Pegawai <span class="text-danger">*</span></label>
        <select id="{{ $fieldPrefix }}_employee_id" name="employee_id" class="form-select {{ $usesOldInput && $errors->has('employee_id') ? 'is-invalid' : '' }}">
            <option value="">Pilih pegawai</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}" @selected($selectedEmployeeId == $employee->id)>
                    {{ $employee->name }}
                </option>
            @endforeach
        </select>
        @if ($usesOldInput && $errors->has('employee_id'))
            <div class="invalid-feedback">{{ $errors->first('employee_id') }}</div>
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label for="{{ $fieldPrefix }}_treatment_date" class="form-label">Tanggal <span class="text-danger">*</span></label>
        <input type="date" id="{{ $fieldPrefix }}_treatment_date" name="treatment_date"
            class="form-control {{ $usesOldInput && $errors->has('treatment_date') ? 'is-invalid' : '' }}"
            value="{{ $usesOldInput ? old('treatment_date') : ($currentMedicalRecord?->treatment_date?->format('Y-m-d') ?? date('Y-m-d')) }}">
        @if ($usesOldInput && $errors->has('treatment_date'))
            <div class="invalid-feedback">{{ $errors->first('treatment_date') }}</div>
        @endif
    </div>

    <div class="col-12 mb-3">
        <label for="{{ $fieldPrefix }}_complaint" class="form-label">Keluhan</label>
        <textarea id="{{ $fieldPrefix }}_complaint" name="complaint" rows="3" class="form-control {{ $usesOldInput && $errors->has('complaint') ? 'is-invalid' : '' }}" placeholder="Tuliskan keluhan pasien">{{ $usesOldInput ? old('complaint') : ($currentMedicalRecord?->complaint ?? '') }}</textarea>
        @if ($usesOldInput && $errors->has('complaint'))
            <div class="invalid-feedback">{{ $errors->first('complaint') }}</div>
        @endif
    </div>

    <div class="col-12 mb-3">
        <div class="card border shadow-none mb-0">
            <div class="card-header d-flex justify-content-between align-items-center bg-light py-2">
                <h6 class="mb-0 fw-bold">Detail Layanan</h6>
                <button type="button" class="btn btn-sm btn-primary js-add-treatment-row">
                    <i class="ti ti-plus me-1"></i> Tambah Item
                </button>
            </div>
            <div class="card-body p-0">
                <datalist id="{{ $fieldPrefix }}_list_layanan">
                    @foreach ($treatments as $t)
                        <option value="{{ $t->name }}" data-price="{{ $t->price }}"></option>
                    @endforeach
                </datalist>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light text-nowrap">
                            <tr>
                                <th style="min-width: 220px;">Layanan</th>
                                <th style="width: 90px;">Qty</th>
                                <th style="min-width: 150px;">Harga Satuan</th>
                                <th style="min-width: 150px;">Diskon</th>
                                <th style="min-width: 140px;">Subtotal</th>
                                <th style="width: 44px;"></th>
                            </tr>
                        </thead>
                        <tbody class="js-treatment-items" data-list-id="{{ $fieldPrefix }}_list_layanan">
                            @foreach ($initialItems as $itemIndex => $item)
                                @php
                                    $itemName = data_get($item, 'name');
                                    $qty = data_get($item, 'qty', 1);
                                    $price = data_get($item, 'price', 0);
                                    $discount = data_get($item, 'discount', 0);
                                    $subtotal = max(0, ((float) $qty * (float) $price) - (float) $discount);
                                @endphp
                                <tr>
                                    <td>
                                        <input list="{{ $fieldPrefix }}_list_layanan" name="treatments[{{ $itemIndex }}][name]" class="form-control form-control-sm name-input" value="{{ $itemName }}" placeholder="Cari atau ketik layanan" required>
                                    </td>
                                    <td>
                                        <input type="number" name="treatments[{{ $itemIndex }}][qty]" class="form-control form-control-sm qty-input text-center" value="{{ $qty }}" min="1">
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" name="treatments[{{ $itemIndex }}][price]" class="form-control price-input js-currency-input" value="{{ number_format((float) $price, 0, ',', '.') }}" placeholder="0">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" name="treatments[{{ $itemIndex }}][discount]" class="form-control discount-input js-currency-input text-danger fw-medium" value="{{ number_format((float) $discount, 0, ',', '.') }}" placeholder="0">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm subtotal-display border-0 bg-transparent fw-bold" readonly value="Rp {{ number_format($subtotal, 0, ',', '.') }}">
                                        <input type="hidden" class="subtotal-value" value="{{ $subtotal }}">
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-link text-danger remove-row p-0">
                                            <i class="ti ti-trash fs-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light text-nowrap">
                            <tr>
                                <th colspan="4" class="text-end text-muted fw-normal">Total Tagihan:</th>
                                <th colspan="2">
                                    <h5 class="mb-0 text-primary fw-bold js-grand-total-text">Rp 0</h5>
                                    <input type="hidden" name="total_cost" class="js-grand-total-value">
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @if ($usesOldInput && $errors->has('treatments'))
            <div class="text-danger small mt-1">{{ $errors->first('treatments') }}</div>
        @endif
    </div>
</div>
