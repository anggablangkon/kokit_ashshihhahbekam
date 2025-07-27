@extends('home.layout')

@section('content')
<section class="bg-opacity-50 border-top border-light position-relative">
	<div class="container pt-5 position-relative pb-5">
		<!-- Hero Content Row -->
		<div class="row">
			<div class="col-lg-8 mx-auto">
				<div class="d-flex flex-column flex-md-row align-items-start gap-3">
					<img src="{{ asset('internal/assets/pakade.png') }}" class="rounded-circle" width="100" height="100" alt="Logo">

					<div class="bg-light border rounded shadow-sm p-3" style="font-size: 14px; text-align: justify;">
						<strong>KU’KUMPUL</strong> merupakan sebuah gerakan pemberian bantuan dana dalam bidang sosial kemasyarakatan dan pendidikan yang diinisiasi oleh <strong>Ade Sudirman</strong> (Pimpinan Kelompok Belajar SC The Smartmaker) pada tanggal <strong>02 Mei 2023</strong> di Menes. <br><br>
						KU’KUMPUL ini bertujuan untuk membantu orang lain tanpa syarat dan ikatan. Dana yang terkumpul tiap bulannya akan dibagikan <strong>100%</strong> sesuai jumlah dana yang ada.
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="section-custom position-relative overflow-hidden" id="reviews">

</section>

<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded-4 shadow">
			<div class="modal-header bg-primary text-white rounded-top-4">
				<h5 class="modal-title fw-semibold" id="formModalLabel">Jadilah Kontributor</h5>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form>
				<div class="modal-body p-4">
					<div class="row mb-3">
						<div class="alert alert-danger">
							<b class="text-black"> Setiap Rupiah yang anda berikan sangat berarti bagi mereka. </b>
						</div>
						<div class="col-md-6">
							<label for="nama" class="form-label">Nama **</label>
							<input type="text" class="form-control border-success" id="nama" placeholder="Masukkan nama" required>
						</div>
						<div class="col-md-6">
							<label for="nohp" class="form-label">No. HP **</label>
							<input type="tel" class="form-control border-success" id="nohp" placeholder="08xxxxxxx" required>
						</div>
					</div>
					<div class="mb-3">
						<label for="nominal" class="form-label">Domisili **</label>
						<select class="form-control">
							<option value="Banten"> Banten </option>
						</select>
					</div>
					<div class="mb-3">
						<label for="nominal" class="form-label">Masukan Nominal **</label>
						<input type="text" class="form-control border-success" id="nominal" placeholder="Masukkan total nominal" required>
					</div>
				</div>

				<div class="modal-footer px-4 pb-4">
					<button type="submit" class="btn btn-primary">Pembayaran / Transfer</button>
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection