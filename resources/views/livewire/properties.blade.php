<div class="container py-4">
    @if($properties->isEmpty())
    <div class="alert alert-light text-center border shadow-sm rounded-4 p-5">
        <i class="bi bi-houses fs-1 text-secondary mb-3 d-block"></i>
        <h5 class="fw-medium mb-0">No Properties Available</h5>
        <p class="text-muted mb-0"><small>Check back later for new listings</small></p>
    </div>
    @else
    <div class="row g-4">
        @foreach($properties as $property)
        @php
        $images = json_decode($property->images, true);
        $carouselId = 'carouselProperty' . $property->id;
        @endphp

        <div class="col-md-3">
            <a href="{{route('property.details', $property->id)}}" class="text-decoration-none text-dark">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 transition-all hover-shadow">
                {{-- Image Carousel --}}
                <div class="position-relative">
                    @if(!empty($images))
                    <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($images as $index => $img)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $img) }}"
                                    class="d-block w-100"
                                    alt="{{ $property->name }}"
                                    style="height: 200px; object-fit: cover;">
                            </div>
                            @endforeach
                        </div>

                        {{-- Carousel Controls --}}
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#{{ $carouselId }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#{{ $carouselId }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                    @else
                    <img src="{{ asset('images/no-image.jpg') }}"
                        class="w-100"
                        alt="No Image Available"
                        style="height: 200px; object-fit: cover;">
                    @endif

                    {{-- Property Type Badge --}}
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-dark fw-medium">{{ $property->type }}</span>
                    </div>

                    {{-- Save Button --}}
                    <button class="btn btn-light opacity-75 btn-sm position-absolute top-0 end-0 m-3 rounded-circle"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-bookmark-fill"></i>
                    </button>
                </div>

                <div class="card-body d-flex flex-column gap-2">
                    {{-- Price --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-medium mb-0">₱{{ number_format($property->cost, 2) }}</span>
                        <small class="text-muted">{{ $property->tenantType }}</small>
                    </div>

                    {{-- Property Name --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="card-title fw-medium mb-0"><small>{{ $property->name }}</small></span>

                         {{-- Address --}}
                    @php
                    $address = $property->address;
                    $city = $address; // fallback if parsing fails

                    // Try to extract city-level names (e.g., "Pasig", "Pasay", "Quezon City", "Lucena")
                    if (preg_match('/\b([A-Z][a-z]+(?:\sCity)?|[A-Z][a-z]+\s[A-Z][a-z]+(?:\sCity)?)\b(?=,|\s|$)/', $address, $matches)) {
                    $city = $matches[1];
                    }
                    @endphp

                    <p class="card-text text-muted small mb-0">
                        {{ $city }}
                        <i class="bi bi-geo-alt-fill"></i>
                    </p>
                    </div>
                    
                </div>
            </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif

    <style>
        .transition-all {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
        }
    </style>
</div>