<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="home-section">
        <div class="container mt-5 mt-md-0">
            <div class="row justify-content-center align-items-center vh-100">

                <!--left side-->
                <div class="col-12 col-md-12 col-lg-6 mb-4 mb-md-0">
                    <p class="fs-4 fw-medium mt-0 mb-0 animate-fade-in" style="animation-delay: 0.1s;">
                        Connecting tenants with verified host and convenient boarding homes.
                    </p>

                    <p class="fs-6 fw-medium mt-0 text-secondary animate-fade-in" style="animation-delay: 0.2s;">Discover more rental options across our available locations <i class="bi bi-geo-alt"></i>.</p>

                    <div class="d-flex gap-2 animate-fade-in" style="animation-delay: 0.3s;">


                    </div>

                    <!-- Feature -->
                    <div class="d-flex flex-wrap gap-2 justify-content-start mt-3">
                        <div class="d-flex flex-column align-items-center justify-content-center text-center bg-white border border-success rounded feature-box shadow-sm animate-float" style="animation-delay: 0.4s;">
                            <i class="bi bi-shield-check feature-icon text-success"></i>
                            <span class="fw-medium feature-label">Safe &amp; Secure</span>
                        </div>

                        <div class="d-flex flex-column align-items-center justify-content-center text-center bg-white border border-primary rounded feature-box shadow-sm animate-float" style="animation-delay: 0.5s;">
                            <i class="bi bi-search feature-icon text-primary"></i>
                            <span class="fw-medium feature-label">Easy Search</span>
                        </div>

                        <div class="d-flex flex-column align-items-center justify-content-center text-center bg-white border border-info rounded feature-box shadow-sm animate-float" style="animation-delay: 0.6s;">
                            <i class="bi bi-people feature-icon text-info"></i>
                            <span class="fw-medium feature-label">Trusted Community</span>
                        </div>

                        <div class="d-flex flex-column align-items-center justify-content-center text-center bg-white border border-warning rounded feature-box shadow-sm animate-float" style="animation-delay: 0.7s;">
                            <i class="bi bi-phone feature-icon text-warning"></i>
                            <span class="fw-medium feature-label">Tech Support</span>
                        </div>
                    </div>

                    <!-- Platforms -->
                    <div class="d-flex flex-column gap-2 mt-3 animate-fade-in" style="animation-delay: 0.8s;">
                        <span class="small fw-medium">Connect with us.</span>
                        <div class="d-flex gap-2 flex-wrap">
                            <x-buttons.small-button>
                                <i class="bi bi-threads"></i> <span class="d-none d-sm-inline">Threads</span>
                            </x-buttons.small-button>
                            <x-buttons.small-button>
                                <i class="bi bi-meta"></i> <span class="d-none d-sm-inline">Meta</span>
                            </x-buttons.small-button>
                            <x-buttons.small-button>
                                <i class="bi bi-twitter-x"></i> <span class="d-none d-sm-inline">Twitter</span>
                            </x-buttons.small-button>
                            <x-buttons.small-button>
                                <i class="bi bi-instagram"></i> <span class="d-none d-sm-inline">Instagram</span>
                            </x-buttons.small-button>
                        </div>
                    </div>
                </div>

                <!--right side-->
                <div class="col-12 col-md-12 col-lg-6">
                    <div class="row g-2 d-flex animate-float">
                        <div class="col-7 col-sm-6 d-flex align-items-center">
                            <img src="{{asset('images/image1.png')}}" alt="Property 1"
                                class="img-fluid shadow rounded w-100"
                                style="height: 340px; max-height: 340px; object-fit: cover;" />
                        </div>
                        <div class="col-5 col-sm-6 d-flex flex-column justify-content-between gap-2">
                            <img src="{{asset('images/image7.jpg')}}" alt="Property 2"
                                class="img-fluid shadow rounded w-100"
                                style="height: 165px; object-fit: cover;" />
                            <img src="{{asset('images/image3.jpg')}}" alt="Property 3"
                                class="img-fluid shadow rounded w-100"
                                style="height: 165px; object-fit: cover;" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>