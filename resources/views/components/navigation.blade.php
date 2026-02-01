<div class="nav-section fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-0 transition-all" id="mainNavbar">
        <div class="container">
            <!-- Brand -->
            <div>
                <x-logo-dark style="width:30px;" />
                <span class="fs-6 fw-semibold"><small>Boardmate</small></span>
            </div>

            <!-- Compact Search Button (shown when scrolled) -->
            <button
                class="btn btn-light rounded-pill shadow-sm compact-search-btn d-none align-items-center gap-2 px-3"
                id="compactSearchBtn"
                type="button">
                <i class="bi bi-search"></i>
                <span class="small fw-medium">Search properties</span>
                <div class="vr"></div>
                <i class="bi bi-sliders"></i>
            </button>

            <!-- Navbar content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Center menu -->
                @guest
                <ul class="navbar-nav mx-auto gap-4 fw-medium small flex-row">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }} small" href="{{route('welcome')}}" wire:navigate>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('properties') ? 'active' : '' }} small" href="" wire:navigate>Endorse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }} small" href="{{route('home')}}" wire:navigate>Properties</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }} small" href="" wire:navigate>Contact</a>
                    </li>
                </ul>
                @endguest

                @auth
                <ul class="navbar-nav mx-auto gap-4 fw-medium small flex-row">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('endorse-page') ? 'active' : '' }}" href="" wire:navigate>Endorse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }} small" href="{{route('home')}}" wire:navigate>Properties</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('verified-hosts') ? 'active' : '' }}" href="{{route('verified-hosts')}}" wire:navigate>Verified Host</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('') ? 'active' : '' }}" href="" wire:navigate>See Nearby</a>
                    </li>
                </ul>
                @endauth
            </div>

            <!-- Right side auth buttons -->
            @guest
            <div class="gap-2">
                <x-buttons.small-button variant="outline-dark" href="{{route('login')}}" class="fw-semibold">
                    Log In
                </x-buttons.small-button>

                <x-buttons.small-button class="fw-semibold" href="{{route('register')}}">
                    Register
                </x-buttons.small-button>
            </div>
            @endguest

            @auth
            <div class="d-flex align-items-center gap-1">
                @if(auth()->check() && auth()->user()->role === 'tenant')
                <x-buttons.small-button
                    href="{{ route('host.request') }}"
                    variant="btn btn-dark"
                    class="shadow-sm fw-semibold rounded-5 px-3">
                    <span class="me-1">Be a host</span> <i class="bi bi-patch-check-fill"></i>
                </x-buttons.small-button>
                @elseif(auth()->check() && auth()->user()->role === 'host')
                <x-buttons.small-button
                    href="{{route('property-registration')}}"
                    variant="btn btn-dark"
                    class="shadow-sm fw-semibold rounded-5 px-3">
                    Properties <i class="bi bi-plus-lg"></i>
                </x-buttons.small-button>
                @endif

                <div class="btn-group">
                    <button class="btn btn-sm btn-light btn-outline-dark shadow-sm border-1 rounded-5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-chat-dots-fill"></i>
                    </button>
                    <ul class="dropdown-menu">
                    </ul>
                </div>

                <livewire:notification-bell />

                <button
                    class="btn btn-sm btn-dark rounded-circle d-flex align-items-center justify-content-center shadow-sm p-0"
                    style="width: 32px; height: 32px; overflow: hidden;"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasRight">

                    @if(auth()->user()->profile_image)
                    <img
                        src="{{ asset('storage/' . auth()->user()->profile_image) }}"
                        alt="{{ auth()->user()->first_name }}"
                        style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                    @php
                    $firstInitial = strtoupper(substr(auth()->user()->firstName ?? '', 0, 1));
                    $lastInitial = strtoupper(substr(auth()->user()->lastName ?? '', 0, 1));
                    $initials = trim($firstInitial . $lastInitial);
                    if (empty($initials)) {
                    $initials = strtoupper(substr(auth()->user()->name ?? auth()->user()->email ?? 'U', 0, 1));
                    }
                    @endphp
                    <span class="fw-bold small text-uppercase">
                        {{ $initials }}
                    </span>
                    @endif
                </button>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Expandable Property Filter (only on /home route) -->
    @if(request()->routeIs('home'))
    <div class="property-filter-wrapper" id="propertyFilterWrapper">
        @livewire('property-filter')
    </div>
    @endif
</div>

@auth
@php
$user = auth()->user();
@endphp

<div class="offcanvas offcanvas-end offcanvas-profile w-25" tabindex="2" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-body d-flex flex-column h-100">
        <!-- Top: Profile card and menu buttons -->
        <div class="flex-grow-1">
            <x-profile-card />

            <div class="d-flex flex-column gap-2 mt-3">
                <a href="" class="btn btn-small btn-light shadow-sm text-start text-secondary" role="button">
                    <small><i class="bi bi-bell-fill me-2 small"></i> <small>Notifications</small></small>
                </a>

                <a href="" class="btn btn-small btn-light shadow-sm text-start text-secondary" role="button">
                    <small><i class="bi bi-person-lines-fill me-2 small"></i> <small>Connections</small></small>
                </a>

                <a href="" class="btn btn-small btn-light shadow-sm text-start text-secondary" role="button">
                    <small><i class="bi bi-bookmark-fill me-2 small"></i> <small>Property List</small></small>
                </a>

                <a href="" class="btn btn-small btn-light shadow-sm text-start text-secondary" role="button">
                    <small><i class="bi bi-gear-fill me-2 small"></i> <small>Settings</small></small>
                </a>
            </div>
        </div>

        <!-- Bottom: Logout button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <x-buttons.small-button
                type="submit"
                class="w-100 fw-semibold">
                Log Out
            </x-buttons.small-button>
        </form>
    </div>
</div>
@endauth

