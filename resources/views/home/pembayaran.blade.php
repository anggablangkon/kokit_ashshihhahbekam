@extends('home.layout')

@section('content')
<section class="pt-5 pb-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">

				<div class="card shadow-sm mb-4">
					<div class="card-header bg-primary text-white">
						<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3">
							<img src="{{ asset('internal/assets/pakade.png') }}" class="rounded-circle" width="50" height="50" alt="Logo">

							<div>
								<h4 class="fw-bold mb-1 mb-md-0">
									Terima kasih telah menjadi kontributor!
								</h4>
								<p class="mb-0">Silakan transfer sesuai instruksi di bawah ini.</p>
							</div>
						</div>
					</div>
					<div class="card-body">
						<p><strong>Nomor Invoice:</strong><br>
							{{ $data->invoice }}
						</p>
						<p><strong>Nominal yang harus ditransfer:</strong><br>
							<span 
							id="nominal-rupiah" 
							class="text-success fs-2 fw-bold"
							data-rupiah="{{ (int) $data->rupiah}}"
							>

							Rp {{ number_format($data->rupiah, 0, ',', '.') }}
						</span>
						<button class="btn btn-sm btn-outline-primary ms-2 align-baseline" onclick="copyNominal()">
							<i class="bi bi-clipboard"></i> Salin
						</button>
						</p>

						<p><strong>Transfer ke rekening berikut:</strong></p>

						@foreach ($banks as $index => $rek)
	<div class="mb-3 p-3 border rounded bg-light">
		<div><strong>Bank:</strong> {{ $rek->bank_name }}</div>
		<div>
			<strong>Nomor Rekening:</strong>
			<span id="norek-{{ $index }}">{{ $rek->account_number }}</span>
			<button class="btn btn-sm btn-outline-primary ms-2" onclick="copyNoRek({{ $index }})">
				<i class="bi bi-clipboard"></i> Salin
			</button>
		</div>
		<div><strong>Atas Nama:</strong> {{ $rek->account_holder }}</div>
	</div>
@endforeach


						<div class="alert alert-danger mt-4">
							<i class="bi bi-info-circle"></i> Harap transfer <u>sesuai nominal</u> hingga digit terakhir dan <b>simpan bukti transfer</b>.
						</div>

						<div class="text-start">
							<a href="" class="btn btn-success">
								Saya sudah bayar
							</a>
							<a href="{{ url('/') }}" class="btn btn-secondary">Kembali ke Beranda</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('js')
<script src="{{asset('internal/js/pembayaran.js?v='.date('hisd'))}}"></script>
@endsection