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
            <div class="col-12">

                <div class="card">
                    <div class="card-header border-dashed card-tabs d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="card-title">Grafik</h4>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-xxl-12 border-end border-dashed">
                                <div id="orders-chart" style="min-height: 405px;"></div>
                            </div><!-- end col -->
                            <!-- <div class="col-xxl-4" id="SummaryData"> </div>  -->

                        </div> <!-- end row-->
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row-->



        <!-- modal  -->
        <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="/produk_klien" method="POST">
                        @csrf
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_klien" class="form-label">Nama Klien **</label>
                                    <input type="text" class="form-control" required id="nama_klien" name="nama_klien"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jenis_produk" class="form-label">Jenis Produk **</label>
                                    <select class="form-control" id="jenis_produk" required name="jenis_produk" required>
                                        <option value="">-- Pilih Jenis Produk --</option>
                                        <option value="CK">CK</option>
                                        <option value="BT">BT</option>
                                        <option value="BE">BE</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="qty" class="form-label">Qty **</label>
                                <input type="text" class="form-control" required id="qty" name="qty" required>
                            </div>

                            <div class="mb-3">
                                <label for="qty" class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan"></textarea>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- modal kedatangan -->
        <div class="modal fade" id="tambahKedatanganModal" tabindex="-1" aria-hidden="true">
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="/save/kedatangan" method="POST" id="formKedatangan">

                        <!-- CSRF Token (untuk Laravel) -->
                        @csrf
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_klien" class="form-label">PO</label>
                                    <input type="text" class="form-control" readonly id="nopo" name="nopo"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nama_klien" class="form-label">Nama</label>
                                    <input type="text" class="form-control" readonly required id="nama"
                                        name="nama" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="qty" class="form-label">Qty Terkirim **</label>
                                <input type="text" class="form-control" id="qtykedatangan" required name="qty"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="qty" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="produk_id" id="token">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

    <!-- container -->
@endsection