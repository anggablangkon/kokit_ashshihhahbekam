@extends('layouts.layouts')

@section('title', 'Data Pasien')

@section('content')
    <div class="container-fluid">
        <div class="page-title-head d-flex align-items-center justify-content-between py-2">
            <div class="flex-grow-1">
                <h4 class="fs-sm text-uppercase fw-bold m-0">Pasien</h4>
                <p class="text-muted mb-0">Kelola data pasien untuk kebutuhan administrasi dan rekam medis.</p>
            </div>
        </div>

        <div data-table data-table-rows-per-page="10" class="card mt-3">
            <div class="card-header justify-content-between align-items-center border-dashed">
                <h4 class="card-title mb-0">List Data</h4>
                <div class="d-flex gap-2">
                    <a data-bs-toggle="modal" data-bs-target="#modalCreatePatient" class="btn btn-sm btn-secondary">
                        <i class="ti ti-plus me-1"></i> Tambah Pasien
                    </a>
                </div>
            </div>

            <div class="card-header border-light justify-content-between">
                <div class="d-flex gap-2">
                    <div class="app-search">
                        <input data-table-search type="search" class="form-control" placeholder="Cari pasien">
                        <i data-lucide="search" class="app-search-icon text-muted"></i>
                    </div>
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
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Rekam Medis</th>
                            <th class="text-center" style="width: 1%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patients as $index => $patient)
                            <tr>
                                <td class="ps-3">{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $patient->name }}</td>
                                <td>{{ $patient->phone ?: '-' }}</td>
                                <td>{{ $patient->gender === 'male' ? 'Laki-laki' : ($patient->gender === 'female' ? 'Perempuan' : '-') }}</td>
                                <td>{{ $patient->birth_date?->translatedFormat('d M Y') ?: '-' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($patient->address ?: '-', 60) }}</td>
                                <td>{{ $patient->medical_records_count }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-soft-info btn-icon btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modalShowPatient{{ $patient->id }}">
                                            <i class="ti ti-eye fs-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-soft-warning btn-icon btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modalEditPatient{{ $patient->id }}">
                                            <i class="ti ti-edit fs-lg"></i>
                                        </button>
                                        <form action="{{ route('patients.destroy', $patient) }}" method="POST" onsubmit="return confirm('Hapus data pasien ini?')">
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
                                <td colspan="8" class="text-center py-4">Belum ada data pasien.</td>
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

    <div class="modal fade" id="modalCreatePatient" tabindex="-1" aria-hidden="true" data-form-context="patients-create">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form action="{{ route('patients.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="form_context" value="patients-create">
                    <div class="modal-body">
                        @include('admin.partials.validation-alert', ['formContext' => 'patients-create'])
                        @include('admin.patients._form', [
                            'patient' => null,
                            'formContext' => 'patients-create',
                            'fieldPrefix' => 'create_patient',
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

    @foreach ($patients as $patient)
        <div class="modal fade" id="modalShowPatient{{ $patient->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Pasien</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Nama</span>
                                    <div class="fw-semibold">{{ $patient->name }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Nomor Telepon</span>
                                    <div class="fw-semibold">{{ $patient->phone }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Tanggal Lahir</span>
                                    <div class="fw-semibold">{{ $patient->birth_date?->translatedFormat('d F Y') ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Jenis Kelamin</span>
                                    <div class="fw-semibold">{{ $patient->gender === 'male' ? 'Laki-laki' : ($patient->gender === 'female' ? 'Perempuan' : '-') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Jumlah Rekam Medis</span>
                                    <div class="fw-semibold">{{ $patient->medical_records_count }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="border rounded p-3">
                                    <span class="text-muted d-block mb-1">Alamat</span>
                                    <div class="fw-semibold">{{ $patient->address ?: '-' }}</div>
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

        <div class="modal fade" id="modalEditPatient{{ $patient->id }}" tabindex="-1" aria-hidden="true" data-form-context="patients-edit-{{ $patient->id }}">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pasien</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <form action="{{ route('patients.update', $patient) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="form_context" value="patients-edit-{{ $patient->id }}">
                        <div class="modal-body">
                            @include('admin.partials.validation-alert', ['formContext' => 'patients-edit-' . $patient->id])
                            @include('admin.patients._form', [
                                'patient' => $patient,
                                'formContext' => 'patients-edit-' . $patient->id,
                                'fieldPrefix' => 'edit_patient_' . $patient->id,
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
            const context = @json(old('form_context'));
            const createContext = 'patients-create';
            const createModal = document.getElementById('modalCreatePatient');

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

            if (!context || typeof bootstrap === 'undefined') {
                return;
            }

            const modalElement = document.querySelector(`[data-form-context="${context}"]`);

            if (modalElement) {
                bootstrap.Modal.getOrCreateInstance(modalElement).show();
            }
        })();
    </script>
@endpush
