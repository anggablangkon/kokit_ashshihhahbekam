@extends('layouts.layouts')

@section('title', 'Payroll')

@section('content')
    <div class="container-fluid">
        <div class="page-title-head d-flex align-items-center justify-content-between py-2">
            <div class="flex-grow-1">
                <h4 class="fs-sm text-uppercase fw-bold m-0">Payroll</h4>
                <p class="text-muted mb-0">Kelola penggajian pegawai berdasarkan periode pembayaran.</p>
            </div>
        </div>

        <div data-table data-table-rows-per-page="10" class="card mt-3">
            <div class="card-header justify-content-between align-items-center border-dashed">
                <h4 class="card-title mb-0">List Data</h4>
                <div class="d-flex gap-2">
                    <a data-bs-toggle="modal" data-bs-target="#modalCreatePayroll" class="btn btn-sm btn-secondary">
                        <i class="ti ti-plus me-1"></i> Tambah Payroll
                    </a>
                </div>
            </div>

            <div class="card-header border-light justify-content-between">
                <div class="app-search">
                    <input data-table-search type="search" class="form-control" placeholder="Cari payroll">
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
                            <th class="ps-3" style="width: 1%;">No</th>
                            <th>Pegawai</th>
                            <th>Periode</th>
                            <th>Gaji Pokok</th>
                            <th>Komisi</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                            <th>Tanggal Bayar</th>
                            <th class="text-center" style="width: 1%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payrolls as $index => $payroll)
                            <tr>
                                <td class="ps-3">{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $payroll->employee?->name ?: '-' }}</td>
                                <td>{{ $payroll->period_label }}</td>
                                <td>Rp {{ number_format((float) $payroll->basic_salary, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format((float) $payroll->total_commission, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format((float) $payroll->grand_total, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $payroll->status === 'paid' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                                        {{ strtoupper($payroll->status) }}
                                    </span>
                                </td>
                                <td>{{ $payroll->payment_date?->translatedFormat('d M Y') ?: '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-soft-info btn-icon btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modalShowPayroll{{ $payroll->id }}">
                                            <i class="ti ti-eye fs-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-soft-warning btn-icon btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modalEditPayroll{{ $payroll->id }}">
                                            <i class="ti ti-edit fs-lg"></i>
                                        </button>
                                        <form action="{{ route('payrolls.destroy', $payroll) }}" method="POST" onsubmit="return confirm('Hapus data payroll ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-icon btn-sm rounded-circle">
                                                <i class="ti ti-trash fs-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Belum ada data payroll.</td>
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

    <div class="modal fade" id="modalCreatePayroll" tabindex="-1" aria-hidden="true" data-form-context="payrolls-create">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Payroll</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form action="{{ route('payrolls.store') }}" method="POST" autocomplete="off" class="js-payroll-form">
                    @csrf
                    <input type="hidden" name="form_context" value="payrolls-create">
                    <div class="modal-body">
                        @include('admin.partials.validation-alert', ['formContext' => 'payrolls-create'])
                        @include('admin.payrolls._form', [
                            'payroll' => null,
                            'formContext' => 'payrolls-create',
                            'fieldPrefix' => 'create_payroll',
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

    @foreach ($payrolls as $payroll)
        <div class="modal fade" id="modalShowPayroll{{ $payroll->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Payroll</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Pegawai</span>
                                    <div class="fw-semibold">{{ $payroll->employee?->name ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Periode</span>
                                    <div class="fw-semibold">{{ $payroll->period_label }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Gaji Pokok</span>
                                    <div class="fw-semibold">Rp {{ number_format((float) $payroll->basic_salary, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Total Komisi</span>
                                    <div class="fw-semibold">Rp {{ number_format((float) $payroll->total_commission, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Grand Total</span>
                                    <div class="fw-semibold text-primary">Rp {{ number_format((float) $payroll->grand_total, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Status</span>
                                    <div class="fw-semibold">{{ strtoupper($payroll->status) }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Tanggal Pembayaran</span>
                                    <div class="fw-semibold">{{ $payroll->payment_date?->translatedFormat('d F Y') ?: '-' }}</div>
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

        <div class="modal fade" id="modalEditPayroll{{ $payroll->id }}" tabindex="-1" aria-hidden="true" data-form-context="payrolls-edit-{{ $payroll->id }}">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Payroll</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <form action="{{ route('payrolls.update', $payroll) }}" method="POST" autocomplete="off" class="js-payroll-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="form_context" value="payrolls-edit-{{ $payroll->id }}">
                        <div class="modal-body">
                            @include('admin.partials.validation-alert', ['formContext' => 'payrolls-edit-' . $payroll->id])
                            @include('admin.payrolls._form', [
                                'payroll' => $payroll,
                                'formContext' => 'payrolls-edit-' . $payroll->id,
                                'fieldPrefix' => 'edit_payroll_' . $payroll->id,
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
    <script>
        (() => {
            const formatCurrency = (value) => {
                const digits = String(value ?? '').replace(/\D/g, '');

                if (!digits) {
                    return '';
                }

                return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            };

            const parseCurrency = (value) => Number(String(value ?? '').replace(/\D/g, '')) || 0;
            const context = @json(old('form_context'));
            const createContext = 'payrolls-create';
            const createModal = document.getElementById('modalCreatePayroll');

            document.querySelectorAll('.js-currency-input').forEach((input) => {
                input.value = formatCurrency(input.value);
                input.addEventListener('input', () => {
                    input.value = formatCurrency(input.value);
                });
            });

            document.querySelectorAll('.js-payroll-form').forEach((form) => {
                const basicSalary = form.querySelector('.js-payroll-basic');
                const totalCommission = form.querySelector('.js-payroll-commission');
                const totalPreview = form.querySelector('.js-payroll-total-preview');
                const status = form.querySelector('.js-payroll-status');
                const paymentDate = form.querySelector('.js-payroll-payment-date');

                if (!basicSalary || !totalCommission || !totalPreview || !status || !paymentDate) {
                    return;
                }

                const updateGrandTotal = () => {
                    const total = parseCurrency(basicSalary.value) + parseCurrency(totalCommission.value);
                    totalPreview.value = `Rp ${formatCurrency(total) || '0'}`;
                };

                const togglePaymentDate = () => {
                    paymentDate.disabled = status.value !== 'paid';

                    if (status.value !== 'paid') {
                        paymentDate.value = '';
                    }
                };

                basicSalary.addEventListener('input', updateGrandTotal);
                totalCommission.addEventListener('input', updateGrandTotal);
                status.addEventListener('change', togglePaymentDate);

                updateGrandTotal();
                togglePaymentDate();
            });

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

                const totalPreview = form.querySelector('.js-payroll-total-preview');
                const status = form.querySelector('.js-payroll-status');
                const paymentDate = form.querySelector('.js-payroll-payment-date');

                if (totalPreview) {
                    totalPreview.value = 'Rp 0';
                }

                if (paymentDate && status) {
                    paymentDate.disabled = status.value !== 'paid';

                    if (status.value !== 'paid') {
                        paymentDate.value = '';
                    }
                }
            };

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
