@extends('layouts.layouts')

@section('title', 'Rekam Medis')

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
                            <th class="ps-3" style="width: 1%;">No</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Pegawai</th>
                            <th>Keluhan</th>
                            <th>Total Biaya</th>
                            <th class="text-center" style="width: 1%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($medicalRecords as $index => $medicalRecord)
                            <tr>
                                <td class="ps-3">{{ $index + 1 }}</td>
                                <td>{{ $medicalRecord->treatment_date?->translatedFormat('d M Y') }}</td>
                                <td class="fw-semibold">{{ $medicalRecord->patient_display_name }}</td>
                                <td>{{ $medicalRecord->employee_display_name }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($medicalRecord->complaint ?: '-', 60) }}</td>
                                <td>Rp {{ number_format((float) $medicalRecord->total_cost, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-soft-info btn-icon btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modalShowMedicalRecord{{ $medicalRecord->id }}">
                                            <i class="ti ti-eye fs-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-soft-warning btn-icon btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modalEditMedicalRecord{{ $medicalRecord->id }}">
                                            <i class="ti ti-edit fs-lg"></i>
                                        </button>
                                        <form action="{{ route('medical-records.destroy', $medicalRecord) }}" method="POST" onsubmit="return confirm('Hapus rekam medis ini?')">
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
                                <td colspan="7" class="text-center py-4">Belum ada data rekam medis.</td>
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
                                    <div class="fw-semibold">{{ $medicalRecord->complaint }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Tindakan</span>
                                    <div class="fw-semibold">{{ $medicalRecord->action_details }}</div>
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
    <script>
        (() => {
            const formatCurrency = (value) => {
                const digits = String(value ?? '').replace(/\D/g, '');

                if (!digits) {
                    return '';
                }

                return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            };

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
