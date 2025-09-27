<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container-fluid px-5">
        <a class="navbar-brand fw-medium fs-6" href="{{route('landing')}}">
            <img src="{{asset('images/logo.png')}}" alt="Bootstrap" width="45" height="40" class="d-inline-block align-text-center ">
            Boardmate
        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            @guest
            <ul class="navbar-nav ms-auto gap-3 fw-medium ">

                <li class="nav-item">
                    <a class="nav-link" href="{{route('index')}}">Properties</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">How it works?</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>

            </ul>
            @endguest

            @auth
            <ul class="navbar-nav ms-auto gap-5 fw-medium ">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('index') ? 'active' : '' }}" href="{{route('index')}}" href="{{route('index')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-houses-fill" viewBox="0 0 16 16">
                            <path d="M7.207 1a1 1 0 0 0-1.414 0L.146 6.646a.5.5 0 0 0 .708.708L1 7.207V12.5A1.5 1.5 0 0 0 2.5 14h.55a2.5 2.5 0 0 1-.05-.5V9.415a1.5 1.5 0 0 1-.56-2.475l5.353-5.354z" />
                            <path d="M8.793 2a1 1 0 0 1 1.414 0L12 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l1.854 1.853a.5.5 0 0 1-.708.708L15 8.207V13.5a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 4 13.5V8.207l-.146.147a.5.5 0 1 1-.708-.708z" />
                        </svg>
                        <span class="nav-text"><small>Properties</small></span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('index')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                        </svg>
                        <span class="nav-text"><small>Nearby</small></span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('index')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0" />
                        </svg>
                        <span class="nav-text"><small>Host</small></span>
                    </a>
                </li>
            </ul>
            @endauth

            @guest
            <ul class="navbar-nav ms-auto gap-2">
                <!-- Guest sees Login + Register -->
                <li class="nav-item">
                    <a href="{{route('login')}}" class="btn btn-sm btn-outline-dark">Login</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="btn btn-sm btn-dark">Register</a>
                </li>
            </ul>
            @endguest

            @auth
            <ul class="navbar-nav ms-auto gap-2">
                <li class="nav-item ">
                    <a href="{{route('register-properties')}}" class="text-dark  " style="text-decoration: none">
                        <small class="fw-semibold">Be a host</small>
                    </a>
                </li>

                <li class="nav-item">
                    <button class="btn btn-sm btn-outline-dark">
                        <i class="bi bi-chat-dots"></i>
                    </button>
                </li>

                <li class="nav-item">
                    <button class="btn btn-sm btn-outline-dark">
                        <i class="bi bi-bell"></i>
                    </button>
                </li>

                <li class="nav-item">
                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                        <a href="{{route('profile')}}" class="btn btn-sm btn-dark">
                            <i class="bi bi-person-fill"></i>
                            {{auth()->user()->firstname}}
                        </a>

                        <button
                            class="btn btn-sm btn-dark"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight">
                            <i class="bi bi-justify"></i>
                        </button>
                    </div>
                </li>

            </ul>
            @endauth
        </div>
    </div>
</nav>

@auth
<div
    class="offcanvas offcanvas-end w-25"
    tabindex="-1"
    id="offcanvasRight"
    aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-body">

        <div class="shadow rounded p-2 mb-2">

            <a href="{{route('profile')}}" class="btn btn-dark w-100 d-flex align-items-center justify-content-between gap-2 mb-1">
                <img
                    src="{{ auth()->user()->avatar 
                            ? asset('storage/' . auth()->user()->avatar) 
                            : asset('images/default-avatar.png') }}"
                    alt="Profile"
                    class="rounded-circle shadow-lg ouline-dark"
                    style="width: 30px; height: 30px; object-fit: cover;">
                <span>
                    <small>{{auth()->user()->firstname}}</small>
                    <small>{{auth()->user()->lastname}}</small>
                </span>
            </a>

            <a href class="btn btn-outline-dark w-100 d-flex align-items-center justify-content-between gap-2 mb-1">
                <small>Saved List</small>
                <span>
                    <i class="bi bi-bookmark-fill"></i>
                </span>
            </a>

            <a href class="btn btn-outline-dark shadow w-100 d-flex align-items-center justify-content-between gap-2 mb-1">
                <small>Connection</small>
                <span>
                    <i class="bi bi-person-lines-fill"></i>
                </span>
            </a>
        </div>

        <a href class="btn btn-dark w-100 d-flex align-items-center justify-content-between gap-2 mb-1">
            <small>Settings</small>
            <span>
                <i class="bi bi-gear"></i>
            </span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-dark w-100">
                <i class="bi bi-box-arrow-right me-2"></i> <small>Logout</small>
            </button>
        </form>
    </div>
</div>
@endauth