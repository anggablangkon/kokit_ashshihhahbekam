@extends('home.layout')

@section('content')
<section class="bg-opacity-50 border-top border-light position-relative">
	<div class="container pt-5 position-relative pb-5">
		<!-- Hero Content Row -->
		<div class="row">
			<div class="col-lg-8 mx-auto">
				<div class="d-flex flex-column flex-md-row align-items-start gap-3">
					<img src="{{ asset('internal/assets/pakade.png') }}" class="rounded-circle" width="100" height="100" alt="Logo">

					<div class="border rounded shadow-sm p-3" style="font-size: 14px; text-align: justify;">
						<img src="{{ asset('internal/assets/alur.jpg') }}" class="w-100">
						<img src="{{ asset('internal/assets/teknis.jpg') }}" class="w-100">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="section-custom position-relative overflow-hidden" id="reviews">

</section>
@endsection