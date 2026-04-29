@extends('layouts.layouts')

@section('title', 'Data Treatments')

@section('content')
    <div class="container-fluid">
        <div class="page-title-head d-flex align-items-center justify-content-between py-2">
            <div class="flex-grow-1">
                <h4 class="fs-sm text-uppercase fw-bold m-0">Treatments</h4>
                <p class="text-muted mb-0">Kelola daftar treatment beserta harga dan komisi pegawai.</p>
            </div>
        </div>

        <div data-table data-table-rows-per-page="10" class="card mt-3">
            <div class="card-header justify-content-between align-items-center border-dashed">
                <h4 class="card-title mb-0">List Data</h4>
                <div class="d-flex gap-2">
                    <a data-bs-toggle="modal" data-bs-target="#modalCreateTreatment" class="btn btn-sm btn-secondary">
                        <i class="ti ti-plus me-1"></i> Tambah Treatment
                    </a>
                </div>
            </div>

            <div class="card-header border-light justify-content-between">
                <div class="app-search">
                    <input data-table-search type="search" class="form-control" placeholder="Cari treatment">
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
                            <th>Nama Treatment</th>
                            <th>Harga</th>
                            <th>Komisi</th>
                            <th>Deskripsi</th>
                            <th class="text-center" style="width: 1%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($treatments as $index => $treatment)
                            <tr>
                                <td class="ps-3">{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $treatment->treatment_name }}</td>
                                <td>Rp {{ number_format((float) $treatment->price, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format((float) $treatment->employee_commission, 0, ',', '.') }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($treatment->description ?: '-', 70) }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-soft-info btn-icon btn-sm rounded-circle"
                                            data-bs-toggle="modal" data-bs-target="#modalShowTreatment{{ $treatment->id }}">
                                            <i class="ti ti-eye fs-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-soft-warning btn-icon btn-sm rounded-circle"
                                            data-bs-toggle="modal" data-bs-target="#modalEditTreatment{{ $treatment->id }}">
                                            <i class="ti ti-edit fs-lg"></i>
                                        </button>
                                        <form action="{{ route('treatments.destroy', $treatment) }}" method="POST"
                                            onsubmit="return confirm('Hapus data treatment ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-soft-danger btn-icon btn-sm rounded-circle">
                                                <i class="ti ti-trash fs-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Belum ada data treatment.</td>
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

    <div class="modal fade" id="modalCreateTreatment" tabindex="-1" aria-hidden="true"
        data-form-context="treatments-create">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Treatment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form action="{{ route('treatments.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="form_context" value="treatments-create">
                    <div class="modal-body">
                        @include('admin.partials.validation-alert', ['formContext' => 'treatments-create'])
                        @include('admin.treatments._form', [
                            'treatment' => null,
                            'formContext' => 'treatments-create',
                            'fieldPrefix' => 'create_treatment',
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

    @foreach ($treatments as $treatment)
        <div class="modal fade" id="modalShowTreatment{{ $treatment->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Treatment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Nama Treatment</span>
                                    <div class="fw-semibold">{{ $treatment->treatment_name }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Harga</span>
                                    <div class="fw-semibold">Rp
                                        {{ number_format((float) $treatment->price, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Komisi</span>
                                    <div class="fw-semibold">Rp
                                        {{ number_format((float) $treatment->employee_commission, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="border rounded p-3">
                                    <span class="text-muted d-block mb-1">Deskripsi</span>
                                    <div class="fw-semibold">{{ $treatment->description ?: '-' }}</div>
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

        <div class="modal fade" id="modalEditTreatment{{ $treatment->id }}" tabindex="-1" aria-hidden="true"
            data-form-context="treatments-edit-{{ $treatment->id }}">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Treatment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <form action="{{ route('treatments.update', $treatment) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="form_context" value="treatments-edit-{{ $treatment->id }}">
                        <div class="modal-body">
                            @include('admin.partials.validation-alert', [
                                'formContext' => 'treatments-edit-' . $treatment->id,
                            ])
                            @include('admin.treatments._form', [
                                'treatment' => $treatment,
                                'formContext' => 'treatments-edit-' . $treatment->id,
                                'fieldPrefix' => 'edit_treatment_' . $treatment->id,
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
            const createContext = 'treatments-create';
            const createModal = document.getElementById('modalCreateTreatment');

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
