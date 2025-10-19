<x-layouts.app>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: calc(100vh - 80px);">
            <div class="col-12 col-lg-6  slide-in-left">
                <p class="fs-1 mb-1 fw-semibold">In Boardmate, <br> We Find Home.</p>
                <p class="fw-medium mb-0 mt-0">Connecting tenants with trusted and verified property agents.</p>
                <p class="fw-medium mt-0">Discover more rental homes across our available locations.</p>

                <div class="d-flex gap-2 mt-3">
                    <a href="" class="btn btn-sm btn-dark">Get Started</a>
                    <a href="{{route('profile')}}" class="btn btn-sm btn-outline-dark">Explore</a>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-sm btn-dark"><i class="bi bi-google"></i></button>
                    <button class="btn btn-sm btn-dark"><i class="bi bi-meta"></i></button>
                    <button class="btn btn-sm btn-dark"><i class="bi bi-geo-alt-fill"></i></button>
                </div>
            </div>

            <div class="col-12 col-lg-6 p-4 slide-in-up">
                <div class="row g-2">
                    <div class="col-6 d-flex align-items-center">
                        <img src="{{asset('images/image1.png')}}" alt="Property 1"
                            class="img-fluid border border-dark rounded"
                            style="height: 260px; object-fit: cover;" />
                    </div>
                    <div class="col-6 d-flex flex-column justify-content-between">
                        <img src="{{asset('images/image2.webp')}}" alt="Property 2"
                            class="img-fluid border border-dark rounded mb-2"
                            style="height: 128px; object-fit: cover;" />
                        <img src="{{asset('images/image3.jpeg')}}" alt="Property 3"
                            class="img-fluid border border-dark rounded"
                            style="height: 128px; object-fit: cover;" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>