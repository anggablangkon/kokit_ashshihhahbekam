@extends('layouts.layouts')
@section('title', 'Data Terkirim')

@section('content')
    <div class="container-fluid mt-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Data Terkirim</h4>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali</a>
            </div>
            <div class="card-body">
                <div class="row bg-light p-2 rounded">
                    <div class="col-md-4">
                        <h5>Nama Klien</h5>
                        <p class="fw-semibold bg-white p-2 rounded">{{ $klien->nama_klien }}</p>
                    </div>
                    <div class="col-md-4">
                        <h5>No PO</h5>
                        <p class="fw-semibold bg-white p-2 rounded">{{ $klien->no_po }}</p>
                    </div>
                    <div class="col-md-4">
                        <h5>Jenis Produk</h5>
                        <p class="fw-semibold bg-white p-2 rounded">{{ $klien->jenis_produk }}</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="horizontal-scroll">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Tanggal</th>
                                <th>Qty</th>
                                <th>Terkirim</th>
                                <th>Sisa</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kedatangan as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ tglindojammenit($item->created_at) ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($loop->first)
                                            <div class="p-2">
                                                <strong>{{ angka($klien->qty) }}</strong>
                                                <br>(QTY Awal)
                                            </div>
                                        @else
                                            <div class="p-2">
                                                <strong>{{ angka($item->qty_kiri) }}</strong>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="p-2">
                                            <strong>{{ angka($item->qty) }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="p-2">
                                            <strong>{{ angka($item->sisa) }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="p-2">
                                            {{ $item->keterangan }}
                                        </div>
                                    </td>
                                    <td>
                                        <form id="formHapusTerkirim{{ $item->id }}"
                                            action="{{ route('kedatangan.destroy', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="konfirmasiHapusTerkirim({{ $item->id }})">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#horizontal-scroll').DataTable();
        });

        function konfirmasiHapusTerkirim(id) {
            Swal.fire({
                title: 'Yakin hapus data ini?',
                text: 'Data yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formHapusTerkirim' + id).submit();
                }
            });
        }
    </script>
@endpush
