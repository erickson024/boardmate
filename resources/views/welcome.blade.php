<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boardmate</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-navigation /> <!--including navigation-->

    <div class="home-section">
        <div class="container home-margin">
            <div class="row justify-content-center align-items-center vh-100">

                <!--left side-->
                <div class="col-12 col-md-12 col-lg-6 mb-4 mb-md-0">
                    <p class="fs-4 fw-medium mt-0 mb-0 animate-fade-in" style="animation-delay: 0.1s;">
                        Connecting tenants with verified host and convenient boarding homes.
                    </p>

                    <p class="fs-6 fw-medium mt-0 text-secondary animate-fade-in" style="animation-delay: 0.2s;">Discover more rental options across our available locations <i class="bi bi-geo-alt"></i>.</p>

                    <!-- Feature -->
                    <div class="d-flex flex-wrap gap-2 justify-content-start">
                        <div class="d-flex flex-column align-items-center justify-content-center text-center bg-white border border-success rounded feature-box shadow-sm animate-float" style="animation-delay: 0.4s;">
                            <i class="bi bi-shield-fill-check feature-icon text-success"></i>
                            <span class="fw-medium feature-label">Safe &amp; Secure</span>
                        </div>

                        <div class="d-flex flex-column align-items-center justify-content-center text-center bg-white border border-primary rounded feature-box shadow-sm animate-float" style="animation-delay: 0.5s;">
                            <i class="bi bi-search feature-icon text-primary"></i>
                            <span class="fw-medium feature-label">Vast Listing Properties</span>
                        </div>

                        <div class="d-flex flex-column align-items-center justify-content-center text-center bg-white border border-info rounded feature-box shadow-sm animate-float" style="animation-delay: 0.6s;">
                            <i class="bi bi-people-fill feature-icon text-info"></i>
                            <span class="fw-medium feature-label">Trusted Community</span>
                        </div>

                        <div class="d-flex flex-column align-items-center justify-content-center text-center bg-white border border-warning rounded feature-box shadow-sm animate-float" style="animation-delay: 0.7s;">
                            <i class="bi bi-pin-map-fill feature-icon text-warning"></i>
                            <span class="fw-medium feature-label">Google Map Interaction</span>
                        </div>
                    </div>

                    <div class="d-flex gap-2 animate-fade-in mt-3" style="animation-delay: 0.3s;">
                        <x-buttons.small-button variant="outline-dark" class="fw-semibold">
                            Get Started
                        </x-buttons.small-button>

                        <x-buttons.small-button class="fw-semibold">
                            Explore
                        </x-buttons.small-button>
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

    <x-footer />
</body>

</html>