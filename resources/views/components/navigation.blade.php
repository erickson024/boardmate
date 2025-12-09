<div class="nav-section fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-0">
        <div class="container">
            <!-- Brand -->
            <div>
                <x-logo-dark style="width:40px;" />
                <span class="fs-6 fw-semibold">Boardmate</span>
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
                        <a class="nav-link {{ request()->routeIs('properties-page') ? 'active' : '' }} small" href="">Properties</a>
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
                        <a class="nav-link {{ request()->routeIs('properties-page') ? 'active' : '' }}" href="" wire:navigate>Properties</a>
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
                <x-buttons.small-button variant="outline-dark" class="fw-semibold">
                    Log In 
                </x-buttons.small-button>

                <x-buttons.small-button  class="fw-semibold" href="{{route('register')}}">
                    Register 
                </x-buttons.small-button>
            </div>
            @endguest

            @auth
            <div class="gap-2">
            

                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-dark rounded" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-chat-dots-fill"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item active" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Separated link</a></li>
                    </ul>
                </div>

                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">

                  

                        <button
                            class="btn btn-sm btn-dark border border-secondary"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                            </svg>
                        </button>
                </div>
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
      

    </div>
</div>
</div>
@endauth