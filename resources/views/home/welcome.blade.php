@extends('home.layout')

@section('content')
<section class="bg-light bg-opacity-50 border-top border-light position-relative">

        <!-- Background Pattern -->
       <div class="position-absolute top-0 start-50 translate-middle-x mt-5 mb-5">
    <img src="{{ asset('tema/assets/images/bg-pattern.png') }}" alt="" class="w-100">
</div>

        <div class="container pt-5 position-relative pb-5">
            <!-- Hero Content Row -->
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="my-4 fs-36 fw-bold lh-base">
                        <span class="text-warning">KU'KUMPUL</span>
                        <span class="text-dark">Gerakan Berbagi</span> 
                        <span class="text-muted fst-italic">Untuk Sosial & Pendidikan Tanpa Syarat</span>
                    </h1>
                    <!-- Total Donasi Box -->
                    <div class="form-grouo">
                        <label> Periode </label>
                        <select id="tahun" class="shadow-sm rounded-3">
                            <option selected disabled>Pilih Periode</option>
                            <option value="{{date('m-Y')}}">{{date('M Y')}}</option>
                        </select>
                        <button class="btn btn-sm btn-secondary rounded-pill">Tampilkan</button>
                    </div>
                    <div class="my-4">
                        <div class="bg-light p-4 rounded-4 shadow-sm d-inline-block">
                            <p class="mb-1 text-secondary">Sudah Terkumpul</p>
                            <h2 class="text-black fw-bold display-5 mb-0">Rp 75.820.000</h2>
                            <b class="text-muted fst-italic">dan terus bertambah 💚</b>
                        </div>
                    </div>

                    <!-- CTA jika dibutuhkan -->
                    <div class="mt-3">
                        <a data-bs-toggle="modal" data-bs-target="#formModal" class="btn btn-primary btn-lg rounded-pill px-4">
                            jadi Kontributor Sekarang Juga ?
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section>
        <div class="position-relative overflow-hidden" 
        style="background-image: url('{{ asset('tema/assets/images/landing-cta.jpg') }}'); background-size: cover; background-position: center; min-height: 400px;">
        
        <!-- Overlay Gelap -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.65);"></div>

        <!-- Konten -->
        <div class="position-relative z-1 d-flex flex-column align-items-center justify-content-center text-center text-white py-5 px-3" style="min-height: 400px;">
            <div class="container">
                <h2 class="fw-bold display-6 mb-3">
                    Bersama <span class="text-warning">KU'KUMPUL</span>, Setiap Rupiah Menjadi Harapan
                </h2>
                <p class="lead mb-4">
                    Gerakan Berbagi Dana, Untuk Sosial & Pendidikan Tanpa Syarat & ikatan.<br>
                    Dana yang terkumpul akan <span class="text-success fw-bold">100%</span> disalurkan kembali kepada mereka yang membutuhkan.
                </p>

                <!-- Tombol CTA -->
                <a href="https://wa.me/6281586777429?text=Halo%2C%20saya%20tertarik%20untuk%20mengetahui%20lebih%20lanjut%20tentang%20program%20kukumpul.%20Mohon%20informasinya%2C%20ya." target="_blank" class="btn btn-lg btn-warning fw-semibold px-4 py-2 shadow-lg">
                    <i class="ti ti-hand-heart me-2 fs-5"></i> Hubungi kami
                </a>
            </div>
        </div>
    </div>
    </section>

    <section class="section-custom position-relative overflow-hidden" id="reviews">

        <!-- background pattern -->
        <div class="position-absolute top-0 start-50 translate-middle-x mt-5 opacity-50">
            <img src="{{asset('tema/assets/images/bg-pattern.png')}}" alt="">
        </div>

        <div class="container position-relative">

            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="mt-3 fw-bold mb-5">Apa kata mereka <mark class="fst-italic">tentang</mark> Ku'kumpul</h2>
                </div>
            </div>  <!-- end row-->          

            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="card border-light rounded-4 p-3 card-h-100">
                        <div class="card-body pb-0 text-center">
                            <div class="avatar avatar-xl mx-auto mb-3">
                                <img src="{{asset('tema/assets/images/users/user-1.jpg')}}" alt="Emily Carter" class="img-fluid rounded-circle">
                            </div>
                            <span class="text-warning fs-lg mb-3 d-block">
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                            </span>
                            <h4 class="mb-2 fs-md">Absolutely love it!</h4>
                            <p class="text-muted mb-3 fst-italic fs-sm">"This gadget exceeded all my expectations. Sleek design and incredible performance!"</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-light rounded-4 p-3 card-h-100">
                        <div class="card-body pb-0 text-center">
                            <div class="avatar avatar-xl mx-auto mb-3">
                                <img src="{{asset('tema/assets/images/users/user-2.jpg')}}" alt="Michael Zhang" class="img-fluid rounded-circle">
                            </div>
                            <span class="text-warning fs-lg mb-3 d-block">
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                            </span>
                            <h4 class="mb-2 fs-md">Great value for money</h4>
                            <p class="text-muted mb-3 fst-italic fs-sm">"Sturdy build and long battery life. Would definitely recommend it to friends!"</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-light rounded-4 p-3 card-h-100">
                        <div class="card-body pb-0 text-center">
                            <div class="avatar avatar-xl mx-auto mb-3">
                                <img src="{{asset('tema/assets/images/users/user-3.jpg')}}" alt="Sara Lopez" class="img-fluid rounded-circle">
                            </div>
                            <span class="text-warning fs-lg mb-3 d-block">
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                            </span>
                            <h4 class="mb-2 fs-md">Top-notch customer service</h4>
                            <p class="text-muted mb-3 fst-italic fs-sm">"The team helped me with my issue right away. Smooth experience overall!"</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-light rounded-4 p-3 card-h-100">
                        <div class="card-body pb-0 text-center">
                            <div class="avatar avatar-xl mx-auto mb-3">
                                <img src="{{asset('tema/assets/images/users/user-4.jpg')}}" alt="James Whitman" class="img-fluid rounded-circle">
                            </div>
                            <span class="text-warning fs-lg mb-3 d-block">
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                            </span>
                            <h4 class="mb-2 fs-md">Highly impressed</h4>
                            <p class="text-muted mb-3 fst-italic fs-sm">"The performance and features are unmatched in this price range. Highly impressed!"</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-light rounded-4 p-3 card-h-100">
                        <div class="card-body pb-0 text-center">
                            <div class="avatar avatar-xl mx-auto mb-3">
                                <img src="{{asset('tema/assets/images/users/user-5.jpg')}}" alt="Aisha Khan" class="img-fluid rounded-circle">
                            </div>
                            <span class="text-warning fs-lg mb-3 d-block">
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                                <span class="ti ti-star-filled"></span>
                            </span>
                            <h4 class="mb-2 fs-md">Smooth experience from start to finish</h4>
                            <p class="text-muted mb-3 fst-italic fs-sm">"The website, shipping, and support all worked flawlessly. Very satisfied!"</p>
                        </div>
                    </div>
                </div>
            </div> <!-- end row-->
        </div> <!-- end container-->
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