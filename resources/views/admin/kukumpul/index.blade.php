@extends('layouts.layouts')
@section('title', 'Halaman Dashboard')

@section('content')
<div class="container-fluid">
    <div class="page-title-head d-flex align-items-center">
        <div class="flex-grow-1">
            <h4 class="fs-sm text-uppercase fw-bold m-0">Kukumpul</h4>
        </div>
    </div>
</div>


<div class="row">
   <div class="col-xxl-12">
    <div class="card">
        <div class="card-header border-dashed">
            <form action="{{url('/admin/kukumpul')}}" method="get">
                <div class="d-flex gap-2">
                    <input type="text" id="monthYearPicker" name="periode" value="{{isset($obj['periode']) ? $obj['periode'] : date('m/Y')}}" readonly class="form-control">
                    <button class="btn btn-sm btn-secondary">
                        Filter
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 title="Terkumpul" class="fw-bold">Terkumpul <small>{{$obj['invoice']}} Kontrobutor</small></h5>
                            <div class="d-flex align-items-center gap-2 my-3">
                                <div class="avatar-md flex-shrink-0">
                                    <span class="avatar-title text-bg-light rounded-circle fs-22">
                                        <i class="ti ti-cash"></i>
                                    </span>
                                </div>
                                <h3 class="mb-0">
                                    Rp. 
                                    <span data-target="{{$obj['terkumpul']}}"></span> 
                                </h3>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-sm-4">
                    <div class="card">
                     <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 title="Tersalurkan" class="fw-bold mb-0">
                                Tersalurkan
                            </h5>
                            <a href=""><i class="ti ti-click"> </i> Penyaluran</a>
                        </div>

                        <div class="d-flex align-items-center gap-2 my-3">
                            <div class="avatar-md flex-shrink-0">
                                <span class="avatar-title text-bg-light rounded-circle fs-22">
                                    <i class="ti ti-cash"></i>
                                </span>
                            </div>
                            <h3 class="mb-0"><span data-target="0"></span></h3>
                        </div>
                    </div> <!-- end card-body-->

                </div>
            </div> <!-- end col-->

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 title="Tersalurkan" class="fw-bold">Sisa</h5>
                        <div class="d-flex align-items-center gap-2 my-3">
                            <div class="avatar-md flex-shrink-0">
                                <span class="avatar-title text-bg-light rounded-circle fs-22">
                                    <i class="ti ti-cash"></i>
                                </span>
                            </div>
                            <h3 class="mb-0"><span data-target="{{$obj['terkumpul']}}"></span></h3>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

        </div>
    </div>
</div>
</div>


<div class="col-xxl-12">
    <div class="card">
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

                            <div class="d-flex align-items-center gap-2">
                                <span class="me-2 fw-semibold">Status Transfer</span>
                                <!-- Date Range Filter -->
                                <div class="app-search">
                                    <select data-table-range-filter="status" class="form-select form-control my-1 my-md-0">
                                        <option value="All" selected>All</option>
                                        <option value="Selesai">Selesai</option>
                                        <option value="Proses">Proses</option>
                                        <option value="Tolak">Tolak</option>
                                    </select>
                                    <i data-lucide="calendar" class="app-search-icon text-muted"></i>
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
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-select table-hover w-100 mb-0">
                                <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                    <tr class="text-uppercase fs-xxs">
                                        <th class="ps-3" style="width: 1%;">NO</th>
                                        <th>Tanggal</th>
                                        <th>Invoice</th>
                                        <th>Nama</th>
                                        <th>Domisili</th>
                                        <th>Email</th>
                                        <th>No HP</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 1%;">
                                            Dukungan
                                        </th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($obj['kukumpul'] as $index => $item)
                                    <tr>
                                        <td class="ps-3">{{ $index + 1 }}</td>
                                        <td>{{ tglindojam($item->created_at) }}</td>
                                        <td>{{ $item->invoice }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->provinsi_id }}</td>
                                        <td>{{ $item->email ?? '-' }}</td>
                                        <td>{{ $item->nohp }}</td>
                                        <td>{{ rupiah($item->rupiah) }}</td>
                                        <td data-column="status">
                                            @if($item->status == 'proses')
                                            <span class="badge bg-warning">Proses</span>
                                            @elseif($item->status == 'tolak')
                                            <span class="badge bg-danger">Tolak</span>
                                            @elseif($item->status == 'sukses')
                                            <span class="badge bg-success">Sukses</span>
                                            @endif
                                        </td>
                                        <td></td>
                                        <td class="text-center">
                                            <a href="{{ route('kukumpul.show', $item->id) }}" 
                                             class="btn btn-sm btn-info btn-view" 
                                             data-id="{{ $item->id }}">
                                             <i class="ti ti-eye"></i>
                                         </a>
                                         @if($item->status == 'proses')
                                         <form action="{{ route('kukumpul.sukses', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Ubah status menjadi Sukses?')">
                                                <i class="ti ti-check"></i>
                                            </button>
                                        @endif
                                        @if($item->status == 'sukses')
                                         <form action="{{ route('kukumpul.reload', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Ubah status menjadi proses kembali?')">
                                                <i class="ti ti-reload"></i>
                                            </button>
                                        @endif
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
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

</div> <!-- end card-->
</div> <!-- end col-->
</div> <!-- end row-->          

<!-- Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalDetailContent" class="text-start">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{asset('internal/js/admin/kukumpul.js?v='.date('His'))}}"></script>
@endsection