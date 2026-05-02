@php
    $adminMenus = \App\Support\AdminMenu::permissions();

    $canAccessMenu = function (array $menu): bool {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        if ($user->can($menu['permission'])) {
            return true;
        }

        foreach ($menu['children'] ?? [] as $child) {
            if ($user->can($child['permission'])) {
                return true;
            }
        }

        return false;
    };
@endphp

<!-- Sidenav Menu Start -->
<div class="sidenav-menu">
    <div class="mb-3">
        <button class="button-on-hover">
            <i class="ti ti-menu-4 fs-22 align-middle"></i>
        </button>
    </div>

    <button class="button-close-offcanvas">
        <i class="ti ti-x align-middle"></i>
    </button>

    <div class="scrollbar" data-simplebar>
        <div class="sidenav-user">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.profile.edit') }}" class="link-reset d-flex align-items-center">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="user-image" class="me-2 avatar-md rounded-circle" style="object-fit: cover;">
                    <div class="d-flex flex-column">
                        <span class="sidenav-user-name fw-bold">{{ Auth::user()->name }}</span>
                        <span class="fs-12 fw-semibold">{{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}</span>
                    </div>
                </a>
            </div>
        </div>

        <ul class="side-nav">
            <li class="side-nav-title" data-lang="menu-title">Menu</li>

            @foreach ($adminMenus as $menu)
                @continue(!$canAccessMenu($menu))

                @if (empty($menu['children']))
                    <li class="side-nav-item">
                        <a href="{{ route($menu['route']) }}" class="side-nav-link">
                            <span class="menu-icon"><i class="{{ $menu['icon'] }}"></i></span>
                            <span class="menu-text">{{ $menu['name'] }}</span>
                        </a>
                    </li>
                @else
                    @php
                        $collapseId = 'sidebar-' . \Illuminate\Support\Str::slug($menu['name']);
                    @endphp
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}" class="side-nav-link">
                            <span class="menu-icon"><i class="{{ $menu['icon'] }}"></i></span>
                            <span class="menu-text">{{ $menu['name'] }}</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="{{ $collapseId }}">
                            <ul class="sub-menu">
                                @foreach ($menu['children'] as $child)
                                    @can($child['permission'])
                                        <li class="side-nav-item">
                                            <a href="{{ route($child['route']) }}" class="side-nav-link">
                                                <span class="menu-text">{{ $child['name'] }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
<!-- Sidenav Menu End -->
