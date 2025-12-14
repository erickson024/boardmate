<div class="nav-section fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-0">
        <div class="container">
            <!-- Brand -->
            <div>
                <x-logo-dark style="width:30px;" />
                <span class="fs-6 fw-semibold"><small>Boardmate</small></span>
            </div>


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
                        <a class="nav-link {{ request()->routeIs('propertyList') ? 'active' : '' }} small" href="{{route('propertyList')}}" wire:navigate>Properties</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }} small" href="" wire:navigate>About & Guide</a>
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
                        <a class="nav-link {{ request()->routeIs('') ? 'active' : '' }}" href="" wire:navigate>Verified Host</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('') ? 'active' : '' }}" href="" wire:navigate>See Nearby</a>
                    </li>
                </ul>
                @endauth
            </div>

            <!-- Right side auth buttons -->
            @guest
            <div class=" gap-2 ">
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
                <x-buttons.small-button href="{{route('host.request')}}" variant="btn btn-secondary" class="shadow-sm  fw-semibold rounded-5">
                    Be a host
                </x-buttons.small-button>

                <div class="btn-group">
                    <button class="btn btn-sm btn-light btn-outline-dark shadow-sm border-1 rounded-5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-chat-dots-fill"></i>
                    </button>
                    <ul class="dropdown-menu">

                    </ul>
                </div>
                
                <x-profile-image size="30" />

                <button
                    class="btn btn-sm btn-dark  rounded-5"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasRight">
                    <i class="bi bi-list"></i>
                </button>

            </div>
            @endauth

        </div>
    </nav>
</div>

@auth
@php
$user = auth()->user();
@endphp

<div class="offcanvas offcanvas-end offcanvas-profile w-25" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">

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
</div>
@endauth