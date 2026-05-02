@extends('layouts.layouts')

@section('title', 'Data Pegawai')

@section('content')
    <div class="container-fluid">
        <div class="page-title-head d-flex align-items-center justify-content-between py-2">
            <div class="flex-grow-1">
                <h4 class="fs-sm text-uppercase fw-bold m-0">Pegawai</h4>
                <p class="text-muted mb-0">Kelola akun pegawai yang tersimpan pada tabel user.</p>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div data-table data-table-rows-per-page="10" class="card mt-3">
            <div class="card-header justify-content-between align-items-center border-dashed">
                <h4 class="card-title mb-0">List Data</h4>
                <a data-bs-toggle="modal" data-bs-target="#modalCreateEmployee" class="btn btn-sm btn-secondary">
                    <i class="ti ti-plus me-1"></i> Tambah Pegawai
                </a>
            </div>

            <div class="card-header border-light justify-content-between">
                <div class="app-search">
                    <input data-table-search type="search" class="form-control" placeholder="Cari pegawai">
                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                </div>
                <select data-table-set-rows-per-page class="form-select form-control my-1 my-md-0" style="max-width: 90px;">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
            </div>

            <div class="table-responsive">
                <table class="table table-custom table-centered table-hover w-100 mb-0">
                    <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                        <tr class="text-uppercase fs-xxs">
                            <th class="ps-3" style="width: 1%;">No</th>
                            <th>Pegawai</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center" style="width: 1%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $index => $employee)
                            <tr>
                                <td class="ps-3">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $employee->profile_photo_url }}"
                                            alt="{{ $employee->name }}"
                                            class="rounded-circle photo-zoomable"
                                            width="42" height="42"
                                            style="object-fit: cover; cursor: pointer;"
                                            data-photo-src="{{ $employee->profile_photo_url }}"
                                            data-photo-name="{{ $employee->name }}"
                                            title="Klik untuk perbesar">
                                        <span class="fw-semibold">{{ $employee->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $employee->email }}</td>
                                <td>
                                    @forelse ($employee->roles as $role)
                                        <span class="badge bg-light text-dark border">{{ $role->name }}</span>
                                    @empty
                                        <span class="text-muted">-</span>
                                    @endforelse
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-soft-info btn-icon btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modalShowEmployee{{ $employee->id }}">
                                            <i class="ti ti-eye fs-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-soft-warning btn-icon btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modalEditEmployee{{ $employee->id }}">
                                            <i class="ti ti-edit fs-lg"></i>
                                        </button>
                                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Hapus data pegawai ini?')">
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
                                <td colspan="5" class="text-center py-4">Belum ada data pegawai.</td>
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

    {{-- Lightbox Modal --}}
    <div class="modal fade" id="modalPhotoZoom" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
            <div class="modal-content border-0 bg-transparent shadow-none">
                <div class="modal-body p-0 text-center position-relative">
                    <button type="button" class="btn btn-dark btn-icon btn-sm rounded-circle position-absolute top-0 end-0 m-2 z-1"
                        data-bs-dismiss="modal" aria-label="Tutup" style="z-index: 10;">
                        <i class="ti ti-x"></i>
                    </button>
                    <img id="zoomedPhoto" src="" alt="" class="img-fluid rounded-3 shadow" style="max-height: 420px; object-fit: contain;">
                    <div id="zoomedPhotoName" class="text-white fw-semibold mt-2 small"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Create --}}
    <div class="modal fade" id="modalCreateEmployee" tabindex="-1" aria-hidden="true" data-form-context="employees-create">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" name="form_context" value="employees-create">
                    <div class="modal-body">
                        @include('admin.partials.validation-alert', ['formContext' => 'employees-create'])
                        @include('admin.employees._form', [
                            'employee' => null,
                            'formContext' => 'employees-create',
                            'fieldPrefix' => 'create_employee',
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
}
    @foreach ($employees as $employee)
        {{-- Modal Show --}}
        <div class="modal fade" id="modalShowEmployee{{ $employee->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Pegawai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100 text-center">
                                    <img src="{{ $employee->profile_photo_url }}"
                                        alt="{{ $employee->name }}"
                                        class="rounded-circle mb-2 photo-zoomable"
                                        width="96" height="96"
                                        style="object-fit: cover; cursor: pointer;"
                                        data-photo-src="{{ $employee->profile_photo_url }}"
                                        data-photo-name="{{ $employee->name }}"
                                        title="Klik untuk perbesar">
                                    <div class="fw-semibold">{{ $employee->name }}</div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="border rounded p-3">
                                            <span class="text-muted d-block mb-1">Email</span>
                                            <div class="fw-semibold">{{ $employee->email }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="border rounded p-3">
                                            <span class="text-muted d-block mb-1">Role</span>
                                            <div class="fw-semibold">{{ $employee->roles->pluck('name')->implode(', ') ?: '-' }}</div>
                                        </div>
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

        {{-- Modal Edit --}}
        <div class="modal fade" id="modalEditEmployee{{ $employee->id }}" tabindex="-1" aria-hidden="true" data-form-context="employees-edit-{{ $employee->id }}">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pegawai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="form_context" value="employees-edit-{{ $employee->id }}">
                        <div class="modal-body">
                            @include('admin.partials.validation-alert', ['formContext' => 'employees-edit-' . $employee->id])
                            @include('admin.employees._form', [
                                'employee' => $employee,
                                'formContext' => 'employees-edit-' . $employee->id,
                                'fieldPrefix' => 'edit_employee_' . $employee->id,
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
            const createContext = 'employees-create';
            const createModal = document.getElementById('modalCreateEmployee');

            const resetCreateForm = () => {
                const form = createModal?.querySelector('form');
                if (!form) return;
                form.reset();
                form.querySelectorAll('.is-invalid').forEach((field) => field.classList.remove('is-invalid'));
                // Reset photo preview inside create modal
                const wrapper = form.querySelector('[id$="_photo_preview_wrapper"]');
                if (wrapper) wrapper.classList.add('d-none');
            };

            createModal?.addEventListener('show.bs.modal', () => {
                if (context !== createContext) resetCreateForm();
            });

            if (context && typeof bootstrap !== 'undefined') {
                const modalElement = document.querySelector(`[data-form-context="${context}"]`);
                if (modalElement) bootstrap.Modal.getOrCreateInstance(modalElement).show();
            }

            const zoomModal    = document.getElementById('modalPhotoZoom');
            const zoomedPhoto  = document.getElementById('zoomedPhoto');
            const zoomedName   = document.getElementById('zoomedPhotoName');

            document.addEventListener('click', (e) => {
                const img = e.target.closest('.photo-zoomable');
                if (!img) return;

                const parentModal = img.closest('.modal');
                if (parentModal) {
                    bootstrap.Modal.getInstance(parentModal)?.hide();
                    parentModal.addEventListener('hidden.bs.modal', openLightbox, { once: true });
                } else {
                    openLightbox();
                }

                function openLightbox() {
                    zoomedPhoto.src  = img.dataset.photoSrc;
                    zoomedPhoto.alt  = img.dataset.photoName;
                    zoomedName.textContent = img.dataset.photoName;
                    bootstrap.Modal.getOrCreateInstance(zoomModal).show();
                }
            });
        })();

        function previewPhoto(input, previewId) {
            const file    = input.files[0];
            const prefix  = input.id.replace('_profile_photo', '');
            const wrapper = document.getElementById(prefix + '_photo_preview_wrapper');
            const preview = document.getElementById(previewId);
            const nameEl  = document.getElementById(prefix + '_photo_name');

            if (!file) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src       = e.target.result;
                nameEl.textContent = file.name;
                wrapper.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }

        function clearPhoto(inputId, previewId, wrapperId) {
            const input   = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const wrapper = document.getElementById(wrapperId);

            if (input)   input.value = '';
            if (preview) preview.src = '';
            if (wrapper) wrapper.classList.add('d-none');
        }
    </script>
@endpush