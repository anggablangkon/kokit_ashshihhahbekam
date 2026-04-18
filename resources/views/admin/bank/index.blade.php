@extends('layouts.layouts')
@section('title', 'Halaman Dashboard')

@section('content')
<div class="container-fluid">

    <div class="page-title-head d-flex align-items-center">
        <div class="flex-grow-1">
            <h4 class="fs-sm text-uppercase fw-bold m-0">Bank</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-xxl-12">
            <div data-table data-table-rows-per-page="5" class="card">
                <div class="card-header justify-content-between align-items-center border-dashed">
                    <h4 class="card-title mb-0">List Data</h4>
                    <div class="d-flex gap-2">
                        <a data-bs-toggle="modal" data-bs-target="#modalAddBank" class="btn btn-sm btn-secondary">
                            <i class="ti ti-plus me-1"></i> Tambah Bank
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">

                    <div class="row">
                        <div class="col-12">
                            <div data-table data-table-rows-per-page="5" class="card">
                                <div class="card-header border-light justify-content-between">
                                    <div class="d-flex gap-2">
                                        <div class="app-search">
                                            <input data-table-search type="search" class="form-control" placeholder="Cari data">
                                            <i data-lucide="search" class="app-search-icon text-muted"></i>
                                        </div>
                                        <button data-table-delete-selected class="btn btn-danger d-none">Delete</button>
                                    </div>

                                    <!-- Records Per Page -->
                                    <div>
                                        <select data-table-set-rows-per-page class="form-select form-control my-1 my-md-0">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-custom table-centered table-select table-hover w-100 mb-0">
                                        <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                            <tr class="text-uppercase fs-xxs">
                                                <th class="ps-3" style="width: 1%;">NO</th>
                                                <th>Bank</th>
                                                <th>Rekening</th>
                                                <th>Atas Nama</th>
                                                <th class="text-center" style="width: 1%;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($obj['banks'] as $index => $bank)
                                                <tr>
                                                    <td class="ps-3">{{ $index + 1 }}</td>
                                                    <td>{{ $bank->bank_name }}</td>
                                                    <td>{{ $bank->account_number }}</td>
                                                    <td>{{ $bank->account_holder }}</td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center gap-1">
                                                            <!-- Tombol Edit -->
                                                            <button class="btn btn-info btn-icon btn-sm rounded-circle" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalEditBank{{ $bank->id }}">
                                                            <i class="ti ti-edit fs-lg"></i>
                                                            </button>

                                                            <!-- Tombol Delete -->
                                                            <form action="{{ route('bank.destroy', $bank->id) }}" 
                                                              method="POST" 
                                                              style="display:inline-block"
                                                              onsubmit="return confirm('Hapus data bank ini?')">
                                                              @csrf
                                                              @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-icon btn-sm rounded-circle">
                                                                    <i class="ti ti-trash fs-lg"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- Modal Edit --}}
                                                <div class="modal fade" id="modalEditBank{{ $bank->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content animated fadeIn">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Data Bank</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form method="POST" autocomplete="off" action="{{ route('bank.update', $bank->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nama Bank</label>
                                                                        <input type="text" name="bank_name" value="{{ $bank->bank_name }}" class="form-control" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nomor Rekening</label>
                                                                        <input type="text" name="account_number" value="{{ $bank->account_number }}" class="form-control" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nama Pemilik Rekening</label>
                                                                        <input type="text" name="account_holder" value="{{ $bank->account_holder }}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="hidden" name="token" value="{{encrypt($bank->id)}}">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data bank</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="card-footer border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div data-table-pagination-info="products"></div>
                                        <div data-table-pagination></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div> <!-- end card-body-->

                <div class="card-footer border-0">
                    <div class="align-items-center justify-content-between row text-center text-sm-start">
                        <div class="col-sm">
                            <div data-table-pagination-info="data"></div>
                        </div>
                        <div class="col-sm-auto mt-3 mt-sm-0">
                            <div data-table-pagination></div>
                        </div> <!-- end col-->
                    </div> <!-- end row-->
                </div> <!-- end card-footer-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div> <!-- end row-->

</div>


<!-- Modal Add Bank -->
<div class="modal fade" id="modalAddBank" tabindex="-1" aria-labelledby="modalAddBankLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddBankLabel">Tambah Data Bank</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <form method="POST" action="{{ route('bank.store') }}" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bank_name" class="form-label">Nama Bank <span class="text-danger">*</span></label>
                        <input type="text" id="bank_name" name="bank_name" class="form-control" placeholder="Contoh: BCA, Mandiri" required>
                    </div>

                    <div class="mb-3">
                        <label for="account_number" class="form-label">Nomor Rekening <span class="text-danger">*</span></label>
                        <input type="text" id="account_number" name="account_number" class="form-control" placeholder="Contoh: 1234567890" required>
                    </div>

                    <div class="mb-3">
                        <label for="account_holder" class="form-label">Nama Pemilik Rekening <span class="text-danger">*</span></label>
                        <input type="text" id="account_holder" name="account_holder" class="form-control" placeholder="Contoh: Andi Setiawan" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection