@extends('layouts.layouts')
@section('title', 'Halaman Dashboard')

@section('content')
<style>
    .label-required::after {
        content: " *";
        color: red;
    }
</style>
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
                        <a data-bs-toggle="modal" data-bs-target="#modalAddTestimonial" class="btn btn-sm btn-secondary">
                            <i class="ti ti-plus me-1"></i> Tambah Data
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
                                                <th>Nama</th>
                                                <th>Foto</th>
                                                <th>Rating</th>
                                                <th>Pesan</th>
                                                <th class="text-center" style="width: 1%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-capitalize">
                                            @foreach ($testimonials as $key => $testimonial)
                                            <tr>
                                                <td class="ps-3">{{ $key + 1 }}</td>
                                                <td>{{ $testimonial->nama }}</td>
                                                <td>
                                                    @if ($testimonial->foto)
                                                    <img src="{{ asset($testimonial->foto) }}" alt="-" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                                    @else
                                                    <span>-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- Tampilkan rating sebagai bintang --}}
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $testimonial->rating)
                                                        <span class="text-warning">&#9733;</span> {{-- bintang filled --}}
                                                        @else
                                                        <span class="text-muted">&#9734;</span> {{-- bintang kosong --}}
                                                        @endif
                                                        @endfor
                                                    </td>
                                                    <td>{{ $testimonial->pesan }}</td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center gap-1">
                                                            <!-- Tombol Edit -->
                                                            <button class="btn btn-info btn-icon btn-sm rounded-circle" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalEditBank{{ $testimonial->id }}">
                                                            <i class="ti ti-edit fs-lg"></i>
                                                        </button>

                                                        <!-- Tombol Delete -->
                                                        <form action="{{ route('testimoni.destroy', $testimonial->id) }}" 
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

<!-- Modal Tambah Testimonial -->
<div class="modal fade" id="modalAddTestimonial" tabindex="-1" aria-labelledby="modalAddTestimonialLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('testimoni.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddTestimonialLabel">Tambah Testimonial</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
    </div>
    <div class="modal-body">

        <div class="mb-3">
          <label for="nama" class="form-label label-required">Nama</label>
          <input type="text" class="form-control" id="nama" name="nama" required maxlength="100" value="{{ old('nama') }}">
      </div>

      <div class="mb-3">
          <label for="foto" class="form-label">Foto</label>
          <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
      </div>

      <div class="mb-3">
          <label for="rating" class="form-label label-required">Rating (1-5)</label>
          <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required value="{{ old('rating') }}">
      </div>

      <div class="mb-3">
          <label for="pesan" class="form-label label-required">Pesan</label>
          <textarea class="form-control" id="pesan" name="pesan" rows="4" required>{{ old('pesan') }}</textarea>
      </div>

  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
</div>
</form>

</div>
</div>


@endsection