@extends('layouts.layouts')
@section('title', 'Halaman Dashboard')

@section('content')
    <div class="container-fluid">

        <div class="page-title-head d-flex align-items-center">
            <div class="flex-grow-1">
                <h4 class="fs-sm text-uppercase fw-bold m-0">Dashboard</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Sistem</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>


        <div class="row">
            <div class="col-xxl-12">
                <div data-table data-table-rows-per-page="5" class="card">
                    <div class="card-header justify-content-between align-items-center border-dashed">
                        <h4 class="card-title mb-0">List Data</h4>
                        <div class="d-flex gap-2">
                            <a data-bs-toggle="modal" data-bs-target="#tambahDataModal" class="btn btn-sm btn-secondary">
                                <i class="ti ti-plus me-1"></i> Data Baru
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">

                        <div>
                            <input type="text" id="searchInput" class="form-control form-control-sm"
                                placeholder="Cari berdasarkan nama klien atau No PO...">
                        </div>

                        <div id="loadingIndicator" style="display:none; text-align:center; padding: 10px;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-custom table-sm table-nowrap table-hover mb-0"
                                id="horizontal-scroll">
                                <thead>
                                    <tr>
                                        <th>Klien</th>
                                        <th>PO</th>
                                        <th>Aksi</th>
                                        <th>Qty</th>
                                        <th>Terkirim</th>
                                        <th>Sisa</th>
                                        <th>Progres</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="topperproduk">
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive-->
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
@endsection