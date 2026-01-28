<div class="overflow-hidden">
    <div class="vh-100 overflow-auto">
        <div class="property-list" style="margin-top: 13%">
            <div class="sticky-top mb-3 bg-white" style=" z-index: 1020">
                <div class="">
                   
                </div>
            </div>
            <div class="container">

                @if($properties->isEmpty())
                <div class=" text-center p-5 ">
                    <i class="bi bi-house-exclamation fs-1"></i>
                    <h5 class="fw-medium mb-0 fs-6">No Properties Available</h5>
                    <p class="text-muted mb-0 small">Check back later for new listings</p>
                </div>
                @else
                <div class="row g-4">
                    @foreach($properties as $property)
                    @php
                    $images = is_array($property->images) ? $property->images : [];
                    $carouselId = 'carouselProperty' . $property->id;
                    @endphp

                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('property.details', $property->id) }}" class="text-decoration-none text-dark">
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
                                        <span class="badge bg-dark fw-medium">{{ $property->propertyType }}</span>

                                        @php
                                        $tenantColors = [
                                        'student' => 'bg-primary',
                                        'employee' => 'bg-success',
                                        'family' => 'bg-info',
                                        'couple' => 'bg-danger',
                                        'groups' => 'bg-danger',
                                        'single' => 'bg-success',
                                        'all' => 'bg-secondary',
                                        // add more types as needed
                                        ];

                                        $tenantType = $property->tenantType;
                                        $badgeColor = $tenantColors[$tenantType] ?? 'bg-dark'; // fallback color
                                        @endphp

                                        <span class="badge {{ $badgeColor }} fw-medium">{{ $tenantType }}</span>
                                    </div>

                                    {{-- Save Button --}}
                                    <button class="btn btn-light opacity-75 btn-sm position-absolute top-0 end-0 m-3 rounded-circle"
                                        style="width: 32px; height: 32px;">
                                        <i class="bi bi-bookmark-fill"></i>
                                    </button>
                                </div>

                                <div class="card-body d-flex flex-column gap-2">

                                    {{-- Property Name --}}
                                    <div class="d-flex justify-content-between align-items-center">
                                        @php
                                        $maxLength = 25; // maximum characters
                                        $propertyName = $property->propertyName;
                                        $displayName = strlen($propertyName) > $maxLength ? substr($propertyName, 0, $maxLength) . '…' : $propertyName;
                                        @endphp

                                        <span class="card-title fw-medium mb-0">
                                            <small>{{ $displayName }}</small>
                                        </span>
                                    </div>

                                    {{-- Property Cost and Address --}}
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-medium small">₱{{ number_format($property->propertyCost, 2) }}</span>

                                        {{-- Address --}}
                                        @php
                                        $address = $property->address;
                                        $city = $address; // fallback

                                        // Split the address by commas
                                        $parts = array_map('trim', explode(',', $address));

                                        // Usually, the city or municipality is the second-to-last or second element
                                        // Adjust based on your address format
                                        if (count($parts) >= 2) {
                                        // Check if the first part is street, second is city
                                        $city = $parts[count($parts) - 3] ?? $parts[0]; // try third-to-last
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

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-3 mb-1">
                    {{ $properties->links('vendor.pagination.custom') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>