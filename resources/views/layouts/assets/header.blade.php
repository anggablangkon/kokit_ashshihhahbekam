<!-- Topbar Start -->
<header class="app-topbar">
    <div class="container-fluid topbar-menu">
        <div class="d-flex align-items-center gap-2">
            <!-- Topbar Brand Logo -->
            <!-- Sidebar Menu Toggle Button -->
            <button class="sidenav-toggle-button btn btn-primary btn-icon">
                <i class="ti ti-menu-4 fs-22"></i>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="topnav-toggle-button px-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="ti ti-menu-4 fs-22"></i>
            </button>
        </div> <!-- .d-flex-->

        <div class="d-flex align-items-center gap-2">

            <!-- Notification Dropdown 
            <div class="topbar-item">
                <div class="dropdown">
                    <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                        data-bs-offset="0,22" type="button" data-bs-auto-close="outside" aria-haspopup="false"
                        aria-expanded="false">
                        <i data-lucide="bell" class="fs-xxl"></i>
                        <span class="badge badge-square text-bg-warning topbar-badge">1</span>
                    </button>

                    <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                        <div class="px-3 py-2 border-bottom">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fs-md fw-semibold">Notifikasi</h6>
                                </div>
                                <div class="col text-end">
                                    <a href="#!" class="badge text-bg-light badge-label py-1">1 Notif</a>
                                </div>
                            </div>
                        </div>

                        <div style="max-height: 300px;" data-simplebar>
                            <div class="dropdown-item notification-item py-2 text-wrap" id="notification-1">
                                <span class="d-flex gap-2">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title bg-danger-subtle text-danger rounded fs-22">
                                            <i data-lucide="server-crash" class="fs-xl fill-danger"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Haiii selamat datang</span>
                                        <br>
                                        <span class="fs-xs">30 menit yang lalu</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0"
                                        data-dismissible="#notification-1">
                                        <i class="ti ti-xbox-x-filled fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                        </div> 
                        <a href="javascript:void(0);"
                            class="dropdown-item text-center text-reset text-decoration-underline link-offset-2 fw-bold notify-item border-top border-light py-2">
                            View All Alerts
                        </a>

                    </div>
                </div>
            </div>
            -->

            <!-- Light/Dark Mode Button -->
            <div class="topbar-item d-none d-sm-flex">
                <button class="topbar-link" id="light-dark-mode" type="button">
                    <i data-lucide="moon" class="fs-xxl mode-light-moon"></i>
                    <i data-lucide="sun" class="fs-xxl mode-light-sun"></i>
                </button>
            </div>

            <!-- User Dropdown -->
            <div class="topbar-item nav-user">
                <div class="dropdown">
                    <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown"
                        data-bs-offset="0,16" href="#!" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ asset('internal/assets/logoix.png') }}" width="32"
                            class="rounded-circle me-lg-2 d-flex" alt="user-image">
                        <div class="d-lg-flex align-items-center gap-1 d-none">
                            <h5 class="my-0">{{ Auth::user()->name }}</h5>
                            <i class="ti ti-chevron-down align-middle"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- Logout -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="javascript:void(0);" class="dropdown-item text-danger fw-semibold"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti ti-logout-2 me-2 fs-17 align-middle"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>
<!-- Topbar End -->
