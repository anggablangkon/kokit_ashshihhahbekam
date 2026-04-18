<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Btech">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('tema/assets/images/bsi.png') }}">
    <!-- jVector Map CSS-->
    <link rel="stylesheet" href="{{ asset('tema/assets/plugins/jsvectormap/jsvectormap.min.css') }}">
    <!-- Theme Config Js -->
    <script src="{{ asset('tema/assets/js/config.js') }}"></script>
    <!-- Vendor css -->
    <link href="{{ asset('tema/assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App css -->
    <link href="{{ asset('tema/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Daterangepicker Plugin CSS -->
    <link rel="stylesheet" href="{{ asset('tema/assets/plugins/daterangepicker/daterangepicker.css')}}" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')

</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        @include('layouts.assets.sidebar')

        @include('layouts.assets.header')

        <div class="content-page">
            @yield('content')

            @include('layouts.assets.footer')
        </div>

    </div>
    <!-- END wrapper -->

    {{-- @include('layouts.assets.themesetting') --}}

    <!-- Vendor js -->
    <script src="{{ asset('tema/assets/js/vendors.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('tema/assets/js/app.js') }}"></script>
    <!-- E Charts js -->
    <script src="{{ asset('tema/assets/plugins/echarts/echarts.min.js') }}"></script>
    <!-- JVector Maps-->
    <script src="{{ asset('tema/assets/plugins/jsvectormap/jsvectormap.min.js') }}"></script>
    <!-- <script src="{{ asset('tema/assets/js/maps/world.js') }}"></script> -->
    <!-- Custom table -->
    <script src="{{ asset('tema/assets/js/pages/custom-table.js') }}"></script>
    <!-- Dashboard 2 Page js -->
    <!-- <script src="{{ asset('tema/assets/js/pages/dashboard-2.js') }}"></script> -->

    <!-- Daterangepicker Plugin Js -->
    <script src="{{ asset('tema/assets/plugins/moment/moment.min.js')}}"></script>
    <script src="{{ asset('tema/assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{ asset('tema/assets/js/pages/form-date-range-picker.js')}}"></script>

    {{-- datatables --}}
    <script src="{{ asset('tema/assets/plugins/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('tema/assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('tema/assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('tema/assets/plugins/datatables/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('tema/assets/js/pages/datatables-scroll.js') }}"></script>
    <script src="{{ asset('internal/js/helper/global.js?v='.date('His')) }}"></script>
    
    @yield('js')
    @stack('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 1500,
                showConfirmButton: false
            });
        </script>
    @endif
</body>

</html>
