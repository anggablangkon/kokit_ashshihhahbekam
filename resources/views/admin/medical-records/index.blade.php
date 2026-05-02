@extends('layouts.layouts')

@section('title', 'Rekam Medis')

@section('css')
    <link rel="stylesheet" href="{{ asset('tema/assets/plugins/select2/select2.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-title-head d-flex align-items-center justify-content-between py-2">
            <div class="flex-grow-1">
                <h4 class="fs-sm text-uppercase fw-bold m-0">Rekam Medis</h4>
                <p class="text-muted mb-0">Catat histori tindakan, keluhan, dan biaya layanan pasien.</p>
            </div>
        </div>

        <div data-table data-table-rows-per-page="10" class="card mt-3">
            <div class="card-header justify-content-between align-items-center border-dashed">
                <h4 class="card-title mb-0">List Data</h4>
                <div class="d-flex gap-2">
                    <a data-bs-toggle="modal" data-bs-target="#modalCreateMedicalRecord" class="btn btn-sm btn-secondary">
                        <i class="ti ti-plus me-1"></i> Tambah Rekam Medis
                    </a>
                </div>
            </div>

            <div class="card-header border-light justify-content-between">
                <div class="app-search">
                    <input data-table-search type="search" class="form-control" placeholder="Cari rekam medis">
                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                </div>
                <div>
                    <select data-table-set-rows-per-page class="form-select form-control my-1 my-md-0">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-custom table-centered table-hover w-100 mb-0">
                    <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                       <tr class="text-uppercase fs-xxs">
                            <th class="ps-3 text-center" style="width: 5%;">No</th>
                            <th style="width: 15%;">Tanggal & Waktu</th>
                            <th style="width: 20%;">Pasien & Pegawai</th>
                            <th style="width: 20%;">Layanan / Treatment</th> <!-- Kolom Baru/Penyesuaian -->
                            <th style="width: 20%;">Keluhan</th>
                            <th style="width: 10%;">Total Biaya</th>
                            <th class="text-center" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($medicalRecords as $index => $medicalRecord)
                            <tr>
                                <td class="ps-3 text-center">{{ $index + 1 }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $medicalRecord->invoice_number }}</span>
                                    <span class="d-block fw-semibold">{{ $medicalRecord->treatment_date?->translatedFormat('d M Y') }}</span>
                                    <small class="text-muted">{{ $medicalRecord->created_at->format('H:i') }} WIB</small>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">{{ $medicalRecord->patient_display_name }}</div>
                                    <small class="text-muted">Terapis: {{ $medicalRecord->employee_display_name }}</small>
                                </td>
                                <td>
                                    <!-- Menampilkan ringkasan item layanan + Harga Satuan -->
                                    <ul class="list-unstyled mb-0 small">
                                        @foreach($medicalRecord->items->take(3) as $item)
                                            <li class="mb-1">
                                                <i class="ti ti-check text-success me-1"></i>
                                                <span class="fw-medium">{{ $item->treatment_name }}</span>
                                                <div class="text-muted ps-3 fw-medium ">
                                                    {{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                                    @if($item->discount > 0)
                                                        <span class="text-danger">(-Rp {{ number_format($item->discount, 0, ',', '.') }})</span>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                        
                                        @if($medicalRecord->items->count() > 3)
                                            <li class="text-muted small ms-3 italic">
                                                + {{ $medicalRecord->items->count() - 3 }} layanan lainnya...
                                            </li>
                                        @endif
                                    </ul>
                                </td>
                                <td>
                                    <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $medicalRecord->complaint }}">
                                        {{ $medicalRecord->complaint ?: '-' }}
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">
                                    Rp {{ number_format((float) $medicalRecord->total_cost, 0, ',', '.') }}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <!-- Tombol Cetak Invoice (Baru) -->
                                        <a href="{{ route('medical-records.invoice', $medicalRecord->id) }}" 
                                        class="btn btn-soft-success btn-icon btn-sm rounded-circle" 
                                        target="_blank" 
                                        title="Cetak Invoice">
                                            <i class="ti ti-printer fs-lg"></i>
                                        </a>

                                        <!-- Tombol Detail -->
                                        <button type="button" class="btn btn-soft-info btn-icon btn-sm rounded-circle" 
                                                data-bs-toggle="modal" data-bs-target="#modalShowMedicalRecord{{ $medicalRecord->id }}"
                                                title="Lihat Detail">
                                            <i class="ti ti-eye fs-lg"></i>
                                        </button>

                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-soft-warning btn-icon btn-sm rounded-circle" 
                                                data-bs-toggle="modal" data-bs-target="#modalEditMedicalRecord{{ $medicalRecord->id }}"
                                                title="Edit Data">
                                            <i class="ti ti-edit fs-lg"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('medical-records.destroy', $medicalRecord) }}" method="POST" 
                                            onsubmit="return confirm('Hapus rekam medis ini? Semua detail layanan juga akan terhapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-icon btn-sm rounded-circle" title="Hapus">
                                                <i class="ti ti-trash fs-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="ti ti-database-off fs-1 d-block mb-2 text-muted"></i>
                                    Belum ada data rekam medis.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div data-table-pagination-info></div>
                    <div data-table-pagination></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCreateMedicalRecord" tabindex="-1" aria-hidden="true" data-form-context="medical-records-create">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Rekam Medis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form action="{{ route('medical-records.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="form_context" value="medical-records-create">
                    <div class="modal-body">
                        @include('admin.partials.validation-alert', ['formContext' => 'medical-records-create'])
                        @include('admin.medical-records._form', [
                            'medicalRecord' => null,
                            'formContext' => 'medical-records-create',
                            'fieldPrefix' => 'create_medical_record',
                        ])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($medicalRecords as $medicalRecord)
        <div class="modal fade" id="modalShowMedicalRecord{{ $medicalRecord->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Rekam Medis</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Nomor Invoice</span>
                                    <div class="fw-semibold">{{ $medicalRecord->invoice_number }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Pasien</span>
                                    <div class="fw-semibold">{{ $medicalRecord->patient_display_name }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Pegawai</span>
                                    <div class="fw-semibold">{{ $medicalRecord->employee_display_name }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Tanggal Treatment</span>
                                    <div class="fw-semibold">{{ $medicalRecord->treatment_date?->translatedFormat('d F Y') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Total Biaya</span>
                                    <div class="fw-semibold">Rp {{ number_format((float) $medicalRecord->total_cost, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Keluhan</span>
                                    <div class="fw-semibold">{{ $medicalRecord->complaint ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="border rounded p-3">
                                    <span class="text-muted d-block mb-2">Detail Layanan</span>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Layanan</th>
                                                    <th class="text-center" style="width: 80px;">Qty</th>
                                                    <th class="text-end">Harga</th>
                                                    <th class="text-end">Diskon</th>
                                                    <th class="text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($medicalRecord->items as $item)
                                                    <tr>
                                                        <td class="fw-semibold">{{ $item->treatment_name }}</td>
                                                        <td class="text-center">{{ $item->qty }}</td>
                                                        <td class="text-end">Rp {{ number_format((float) $item->price, 0, ',', '.') }}</td>
                                                        <td class="text-end">Rp {{ number_format((float) $item->discount, 0, ',', '.') }}</td>
                                                        <td class="text-end fw-semibold">Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEditMedicalRecord{{ $medicalRecord->id }}" tabindex="-1" aria-hidden="true" data-form-context="medical-records-edit-{{ $medicalRecord->id }}">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Rekam Medis</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <form action="{{ route('medical-records.update', $medicalRecord) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="form_context" value="medical-records-edit-{{ $medicalRecord->id }}">
                        <div class="modal-body">
                            @include('admin.partials.validation-alert', ['formContext' => 'medical-records-edit-' . $medicalRecord->id])
                            @include('admin.medical-records._form', [
                                'medicalRecord' => $medicalRecord,
                                'formContext' => 'medical-records-edit-' . $medicalRecord->id,
                                'fieldPrefix' => 'edit_medical_record_' . $medicalRecord->id,
                            ])
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('js')
    <script src="{{ asset('tema/assets/plugins/select2/select2.min.js') }}"></script>
    <script>
        (() => {
            const formatCurrency = (value) => {
                const digits = String(value ?? '').replace(/\D/g, '');

                if (!digits) {
                    return '';
                }

                return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            };

            const parseNumber = (value) => parseFloat(String(value ?? '').replace(/[^0-9]/g, '')) || 0;
            const formatRupiah = (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(value || 0);

            const calculateRow = (row, formWrapper) => {
                const qty = parseFloat(row.querySelector('.qty-input')?.value) || 0;
                const price = parseNumber(row.querySelector('.price-input')?.value);
                const discount = parseNumber(row.querySelector('.discount-input')?.value);
                const subtotal = Math.max(0, (qty * price) - discount);

                row.querySelector('.subtotal-display').value = formatRupiah(subtotal);
                row.querySelector('.subtotal-value').value = subtotal;
                calculateGrandTotal(formWrapper);
            };

            const calculateGrandTotal = (formWrapper) => {
                let total = 0;

                formWrapper.querySelectorAll('.subtotal-value').forEach((input) => {
                    total += parseFloat(input.value) || 0;
                });

                formWrapper.querySelector('.js-grand-total-text').innerText = formatRupiah(total);
                formWrapper.querySelector('.js-grand-total-value').value = total;
            };

            const addTreatmentRow = (formWrapper) => {
                const tbody = formWrapper.querySelector('.js-treatment-items');
                const listId = tbody.dataset.listId;
                const index = Date.now() + Math.floor(Math.random() * 1000);
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>
                        <input list="${listId}" name="treatments[${index}][name]" class="form-control form-control-sm name-input" placeholder="Cari atau ketik layanan" required>
                    </td>
                    <td>
                        <input type="number" name="treatments[${index}][qty]" class="form-control form-control-sm qty-input text-center" value="1" min="1">
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="treatments[${index}][price]" class="form-control price-input js-currency-input" placeholder="0">
                        </div>
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="treatments[${index}][discount]" class="form-control discount-input js-currency-input text-danger fw-medium" placeholder="0" value="0">
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm subtotal-display border-0 bg-transparent fw-bold" readonly value="Rp 0">
                        <input type="hidden" class="subtotal-value" value="0">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-link text-danger remove-row p-0">
                            <i class="ti ti-trash fs-lg"></i>
                        </button>
                    </td>
                `;

                tbody.prepend(row);
                calculateRow(row, formWrapper);
            };

            document.querySelectorAll('.js-medical-record-form').forEach((formWrapper) => {
                const tbody = formWrapper.querySelector('.js-treatment-items');
                const datalist = formWrapper.querySelector('datalist');

                if (!tbody.children.length) {
                    addTreatmentRow(formWrapper);
                }

                formWrapper.querySelector('.js-add-treatment-row')?.addEventListener('click', (event) => {
                    event.preventDefault();
                    addTreatmentRow(formWrapper);
                });

                tbody.addEventListener('click', (event) => {
                    const removeButton = event.target.closest('.remove-row');

                    if (!removeButton) {
                        return;
                    }

                    event.preventDefault();

                    if (tbody.querySelectorAll('tr').length <= 1) {
                        alert('Minimal harus ada satu item layanan.');
                        return;
                    }

                    removeButton.closest('tr').remove();
                    calculateGrandTotal(formWrapper);
                });

                tbody.addEventListener('input', (event) => {
                    const row = event.target.closest('tr');

                    if (!row) {
                        return;
                    }

                    if (event.target.classList.contains('name-input')) {
                        const selectedOption = Array.from(datalist.options).find((option) => option.value === event.target.value);

                        if (selectedOption) {
                            row.querySelector('.price-input').value = formatCurrency(selectedOption.dataset.price);
                        }
                    }

                    if (event.target.classList.contains('js-currency-input')) {
                        event.target.value = formatCurrency(event.target.value);
                    }

                    calculateRow(row, formWrapper);
                });

                tbody.querySelectorAll('tr').forEach((row) => calculateRow(row, formWrapper));
            });

            if (window.jQuery && jQuery.fn.select2) {
                jQuery('.js-patient-select').each(function() {
                    const modal = jQuery(this).closest('.modal');
                    jQuery(this).select2({
                        width: '100%',
                        dropdownParent: modal.length ? modal : jQuery(document.body),
                        placeholder: jQuery(this).data('placeholder') || 'Pilih pasien',
                    });
                });
            }

            const context = @json(old('form_context'));
            const createContext = 'medical-records-create';
            const createModal = document.getElementById('modalCreateMedicalRecord');

            const resetCreateForm = () => {
                if (!createModal) {
                    return;
                }

                const form = createModal.querySelector('form');

                if (!form) {
                    return;
                }

                form.reset();
                form.querySelectorAll('.is-invalid').forEach((field) => field.classList.remove('is-invalid'));
                form.querySelectorAll('.js-currency-input').forEach((input) => {
                    input.value = formatCurrency(input.value);
                });
                form.querySelectorAll('.js-treatment-items').forEach((tbody) => {
                    tbody.innerHTML = '';
                    addTreatmentRow(tbody.closest('.js-medical-record-form'));
                });
            };

            document.querySelectorAll('.js-currency-input').forEach((input) => {
                input.value = formatCurrency(input.value);
                input.addEventListener('input', () => {
                    input.value = formatCurrency(input.value);
                });
            });

            if (createModal) {
                createModal.addEventListener('show.bs.modal', () => {
                    if (context !== createContext) {
                        resetCreateForm();
                    }
                });

                createModal.addEventListener('hidden.bs.modal', () => {
                    if (context !== createContext) {
                        resetCreateForm();
                    }
                });
            }

            if (context && typeof bootstrap !== 'undefined') {
                const modalElement = document.querySelector(`[data-form-context="${context}"]`);

                if (modalElement) {
                    bootstrap.Modal.getOrCreateInstance(modalElement).show();
                }
            }
        })();
    </script>
@endpush
