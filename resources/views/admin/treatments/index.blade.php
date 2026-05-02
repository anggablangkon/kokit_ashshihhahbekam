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
                            <th>Thumbnail</th>
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
                                <td>
                                    @if ($treatment->thumbnail)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($treatment->thumbnail) }}"
                                            alt="{{ $treatment->treatment_name }}"
                                            class="rounded border photo-zoomable"
                                            width="56" height="42"
                                            style="object-fit: cover; cursor: pointer;"
                                            data-photo-src="{{ \Illuminate\Support\Facades\Storage::url($treatment->thumbnail) }}"
                                            data-photo-name="{{ $treatment->treatment_name }}"
                                            title="Klik untuk perbesar">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
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
                                <td colspan="7" class="text-center py-4">Belum ada data treatment.</td>
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
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content border-0 bg-transparent shadow-none">
                <div class="modal-body p-0 text-center position-relative">
                    <button type="button"
                        class="btn btn-dark btn-icon btn-sm rounded-circle position-absolute top-0 end-0 m-2"
                        style="z-index: 10;"
                        data-bs-dismiss="modal"
                        aria-label="Tutup">
                        <i class="ti ti-x"></i>
                    </button>
                    <img id="zoomedPhoto" src="" alt="" class="img-fluid rounded-3 shadow"
                        style="max-height: 460px; object-fit: contain;">
                    <div id="zoomedPhotoName" class="text-white fw-semibold mt-2 small"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Create --}}
    <div class="modal fade" id="modalCreateTreatment" tabindex="-1" aria-hidden="true"
        data-form-context="treatments-create">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Treatment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form action="{{ route('treatments.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
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
        {{-- Modal Show --}}
        <div class="modal fade" id="modalShowTreatment{{ $treatment->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Treatment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100 text-center">
                                    <span class="text-muted d-block mb-2">Thumbnail</span>
                                    @if ($treatment->thumbnail)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($treatment->thumbnail) }}"
                                            alt="{{ $treatment->treatment_name }}"
                                            class="rounded border photo-zoomable"
                                            width="140" height="96"
                                            style="object-fit: cover; cursor: pointer;"
                                            data-photo-src="{{ \Illuminate\Support\Facades\Storage::url($treatment->thumbnail) }}"
                                            data-photo-name="{{ $treatment->treatment_name }}"
                                            title="Klik untuk perbesar">
                                    @else
                                        <div class="text-muted fw-semibold">-</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Nama Treatment</span>
                                    <div class="fw-semibold">{{ $treatment->treatment_name }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-muted d-block mb-1">Harga</span>
                                    <div class="fw-semibold">Rp
                                        {{ number_format((float) $treatment->price, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
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

        {{-- Modal Edit --}}
        <div class="modal fade" id="modalEditTreatment{{ $treatment->id }}" tabindex="-1" aria-hidden="true"
            data-form-context="treatments-edit-{{ $treatment->id }}">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Treatment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <form action="{{ route('treatments.update', $treatment) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
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
                return digits ? digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
            };

            document.querySelectorAll('.js-currency-input').forEach((input) => {
                input.value = formatCurrency(input.value);
                input.addEventListener('input', () => {
                    input.value = formatCurrency(input.value);
                });
            });

            const context       = @json(old('form_context'));
            const createContext = 'treatments-create';
            const createModal   = document.getElementById('modalCreateTreatment');

            const resetCreateForm = () => {
                if (!createModal) return;
                const form = createModal.querySelector('form');
                if (!form) return;
                form.reset();
                form.querySelectorAll('.is-invalid').forEach((f) => f.classList.remove('is-invalid'));
                form.querySelectorAll('.js-currency-input').forEach((input) => {
                    input.value = formatCurrency(input.value);
                });
                const wrapper = form.querySelector('[id$="_thumb_preview_wrapper"]');
                if (wrapper) wrapper.classList.add('d-none');
            };

            if (createModal) {
                createModal.addEventListener('show.bs.modal', () => {
                    if (context !== createContext) resetCreateForm();
                });
                createModal.addEventListener('hidden.bs.modal', () => {
                    if (context !== createContext) resetCreateForm();
                });
            }

            if (context && typeof bootstrap !== 'undefined') {
                const modalEl = document.querySelector(`[data-form-context="${context}"]`);
                if (modalEl) bootstrap.Modal.getOrCreateInstance(modalEl).show();
            }

            const zoomModal   = document.getElementById('modalPhotoZoom');
            const zoomedPhoto = document.getElementById('zoomedPhoto');
            const zoomedName  = document.getElementById('zoomedPhotoName');

            document.addEventListener('click', (e) => {
                const img = e.target.closest('.photo-zoomable');
                if (!img) return;

                e.stopPropagation();

                const openLightbox = () => {
                    zoomedPhoto.src        = img.dataset.photoSrc;
                    zoomedPhoto.alt        = img.dataset.photoName;
                    zoomedName.textContent = img.dataset.photoName;
                    bootstrap.Modal.getOrCreateInstance(zoomModal).show();
                };

                const parentModal = img.closest('.modal');
                if (parentModal) {
                    bootstrap.Modal.getInstance(parentModal)?.hide();
                    parentModal.addEventListener('hidden.bs.modal', openLightbox, { once: true });
                } else {
                    openLightbox();
                }
            });
        })();

        function treatmentPreviewPhoto(input, prefix) {
            const file    = input.files[0];
            const wrapper = document.getElementById(prefix + '_thumb_preview_wrapper');
            const preview = document.getElementById(prefix + '_thumb_preview');
            const nameEl  = document.getElementById(prefix + '_thumb_name');

            if (!file) return;

            const reader  = new FileReader();
            reader.onload = (e) => {
                preview.src                  = e.target.result;
                preview.dataset.photoSrc     = e.target.result;
                preview.dataset.photoName    = file.name;
                nameEl.textContent           = file.name;
                wrapper.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }

        function treatmentZoomPreview(img) {
            if (!img.dataset.photoSrc) return;

            const zoomModal   = document.getElementById('modalPhotoZoom');
            const zoomedPhoto = document.getElementById('zoomedPhoto');
            const zoomedName  = document.getElementById('zoomedPhotoName');

            zoomedPhoto.src        = img.dataset.photoSrc;
            zoomedPhoto.alt        = img.dataset.photoName;
            zoomedName.textContent = img.dataset.photoName;
            bootstrap.Modal.getOrCreateInstance(zoomModal).show();
        }

        function treatmentClearPhoto(prefix) {
            const input   = document.getElementById(prefix + '_thumbnail');
            const preview = document.getElementById(prefix + '_thumb_preview');
            const wrapper = document.getElementById(prefix + '_thumb_preview_wrapper');
            const nameEl  = document.getElementById(prefix + '_thumb_name');

            if (input)   input.value            = '';
            if (preview) { preview.src = ''; preview.dataset.photoSrc = ''; }
            if (nameEl)  nameEl.textContent      = '';
            if (wrapper) wrapper.classList.add('d-none');
        }
    </script>
@endpush