    <!-- Sidenav Menu Start -->
    <div class="sidenav-menu">

        <!-- Brand Logo -->
        <div class="mb-3">
            <!-- Sidebar Hover Menu Toggle Button -->
            <button class="button-on-hover">
                <i class="ti ti-menu-4 fs-22 align-middle"></i>
            </button>
        </div>

        <!-- Full Sidebar Menu Close Button -->
        <button class="button-close-offcanvas">
            <i class="ti ti-x align-middle"></i>
        </button>

        <div class="scrollbar" data-simplebar>

            <!-- User -->
            <div class="sidenav-user">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="pages-profile.html" class="link-reset d-flex align-items-center">
                            <img src="{{ asset('tema/assets/images/bsi.jpg') }}" alt="user-image"
                                class="rounded-circle me-2 avatar-md">
                            
                            <div class="d-flex flex-column">
                                <span class="sidenav-user-name fw-bold">{{ Auth::user()->name }}</span>
                                <span class="fs-12 fw-semibold" data-lang="user-role">Admin</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!--- Sidenav Menu -->
            <ul class="side-nav">
                <li class="side-nav-title" data-lang="menu-title">Menu</li>
                <li class="side-nav-item">
                    <a href="{{ url('/dashboard') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-layout-dashboard"></i></span>
                        <span class="menu-text" data-lang="dashboard">Dashboard</span>
                    </a>
                </li>
                <!-- <li class="side-nav-item">
            <a href="landing.html" target="_blank" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-stack-front"></i></span>
                <span class="menu-text" data-lang="landing-page">Landing Page</span>
            </a>
        </li> -->
            </ul>
        </div>
    </div>
    <!-- Sidenav Menu End -->
