<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <title>kukumpul</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{asset('tema/assets/js/config.js')}}"></script>
    <link href="{{asset('tema/assets/css/vendors.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('tema/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style">
    @yield('css')
</head>

<body class="bg-body-secondary" data-bs-spy="scroll" data-bs-target="#navbar-example">
    <!-- Top Alert -->
    {{-- <div class="alert alert-primary top-alert text-center mb-0 rounded-0 alert-dismissible" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="fst-italic fw-medium">🚀 sistem ini dikembangkan oleh kokitindo.com <a href="https://kokitindo.com" target="_blank" class="fw-semibold fst-normal text-white text-decoration-underline link-offset-3 ms-2">Berkenalan!</a></div>
    </div> --}}
    <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top py-3 shadow-sm">
        <div class="container">
          <!-- Brand -->
          <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            <img src="{{ asset('internal/assets/logo.png') }}" alt="Logo" height="32">
          </a>

          <!-- Toggler (for mobile view) -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Navbar Content -->
          <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Navigation Links -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center">
              <li class="nav-item">
                <a class="nav-link active fw-semibold" href="{{ url('/') }}">Home</a>
              </li>
              <li class="nav-item d-none d-lg-block">
                <span class="nav-link disabled px-2">|</span>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-semibold" href="{{ url('/profil') }}">Berkenalan dengan kami?</a>
              </li>
              <li class="nav-item d-none d-lg-block">
                <span class="nav-link disabled px-2">|</span>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-semibold" href="{{ url('/teknis') }}">Teknis & Alur</a>
              </li>
            </ul>

            <!-- Right-side Icons or Buttons -->
            <div class="d-flex justify-content-center justify-content-lg-end">
              <button class="btn btn-link btn-icon fw-semibold text-body" type="button" id="theme-toggle">
                        <i class="ti ti-contrast fs-22"></i>
                    </button>
            </div>
          </div>
        </div>
      </nav>
    </header>

@yield('content')

<footer class="section-footer text-center">
    <div class="container">
     <div class="row g-4 justify-content-between">
        <div class="col-lg-12 col-xxl-7 text-center">
            <div class="row g-4 text-center">
                <div class="col-6 col-md-4 mx-auto">
                    <div class="d-flex justify-content-center gap-2 mb-2">
                        <a href="#!" class="btn btn-sm btn-icon rounded-circle btn-dark" title="Facebook">
                            <i data-lucide="facebook" class="fs-sm"></i>
                        </a>
                        <a href="#!" class="btn btn-sm btn-icon rounded-circle btn-dark" title="Twitter-x">
                            <i class="ti ti-brand-x fs-sm"></i>
                        </a>
                        <a href="#!" class="btn btn-sm btn-icon rounded-circle btn-dark" title="Instagram">
                            <i data-lucide="instagram" class="fs-sm"></i>
                        </a>
                        <a href="#!" class="btn btn-sm btn-icon rounded-circle btn-dark" title="WhatsApp">
                            <i data-lucide="dribbble" class="fs-sm"></i>
                        </a>                                               
                    </div>
                </div>
            </div> <!-- end row-->
        </div> <!-- end col-->
    </div> <!-- end row-->
    <div class="row mt-2">
        <div class="col-12 text-center">
            <p class="mb-4">🚀 <script>document.write(new Date().getFullYear())</script> Dikembangkan <span class="fw-semibold">oleh kokitindo.com</span> </p>
        </div>
    </div> <!-- end row-->
</div> <!-- end container-->
</footer>

<script src="{{asset('tema/assets/js/vendors.min.js')}}"></script>
<script src="{{asset('tema/assets/js/app.js')}}"></script>
<script src="{{asset('tema/assets/js/pages/landing.js')}}"></script>

@yield('js')


</body>

</html>