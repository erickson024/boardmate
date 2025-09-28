

    <div class="container">
        <div class="row ">
            <!-- Images Carousel -->
            <div class="col-md-6">
                @if(!empty($images))
                <div id="carouselDetail" class="carousel slide shadow rounded-4 overflow-hidden" data-bs-ride="carousel">

                    <!-- Indicators -->
                    @if(count($images) > 1)
                    <div class="carousel-indicators">
                        @foreach($images as $index => $img)
                        <button type="button" data-bs-target="#carouselDetail" data-bs-slide-to="{{ $index }}"
                            class="{{ $index === 0 ? 'active' : '' }}"
                            aria-current="{{ $index === 0 ? 'true' : 'false' }}"></button>
                        @endforeach
                    </div>
                    @endif

                    <!-- Images -->
                    <div class="carousel-inner">
                        @foreach($images as $index => $img)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ Storage::url($img) }}"
                                class="d-block w-100"
                                style="height: 380px; object-fit: cover; transition: transform 0.4s ease-in-out;">
                        </div>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    @if(count($images) > 1)
                    <!-- Previous Button -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselDetail" data-bs-slide="prev"
                        style="width: 15%;">
                        <span class="d-flex align-items-center justify-content-center w-100 h-100 bg-dark bg-opacity-50">
                            <span class="carousel-control-prev-icon"></span>
                        </span>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <!-- Next Button -->
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselDetail" data-bs-slide="next"
                        style="width: 15%;">
                        <span class="d-flex align-items-center justify-content-center w-100 h-100 bg-dark bg-opacity-50">
                            <span class="carousel-control-next-icon"></span>
                        </span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    @endif
                </div>
                @endif
            </div>

            <!-- Property Details -->
            <div class="col-md-6">
                <div class="p-4 bg-white shadow-sm rounded-4 h-100 border border-light-subtle">
                    <!-- Title -->
                    <h5 class="fw-semibold mb-0 text-dark">
                        {{ $property->name }}
                    </h5>

                    <!-- Type as subtitle -->
                    <p class="text-muted mt-0 fs-6">
                        {{ $property->type }} -


                        @php
                        $addressParts = explode(',', $property->address ?? '');
                        // Usually city/town is the second part
                        $city = $addressParts[2] ?? $property->address;
                        @endphp

                        <span>{{ trim($city) }}</span>
                    </p>



                    <!-- Description -->
                    <div class="p-3 bg-light rounded-3">
                        <h6 class="fw-medium">Description</h6>
                        <small class="fw-light text-muted">
                            {{ $property->description }}
                        </small>
                    </div>

                    <div class="row gx-3 mt-2">
                        <div class="col-6 ">
                            <div class="bg-warning p-2 rounded">
                                <h6 class="fw-semibold">Rent Cost</h6>
                                <span class="fw-light d-flex justify-content-end">₱{{ number_format($property->cost, 2) }} montly</span>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="bg-primary p-2 text-light rounded">
                                <h6 class="fw-semibold">Occupancy</h6>
                                <span class="fw-medium d-flex justify-content-end">{{ $property->tenant }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-2">
            <div class=" gap-2 col-6">
                <div class="bg-light p-2 rounded w-100 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="fw-semibold d-block">
                            {{ optional($property->user)->firstname . ' ' . optional($property->user)->lastname ?? 'Unknown' }}
                        </span>
                        <small class="text-muted">Agent</small>
                    </div>
                    <div>

                        @guest

                        <button
                            class="btn btn-sm btn-dark"
                            data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Message
                        </button>

                        <button
                            class="btn btn-sm btn-dark"
                            data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Inquire
                        </button>

                        <button
                            class="btn btn-sm btn-dark"
                            data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Contacts
                        </button>

                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-body">
                                        <h6>This feature is only available for registered users.</h6>
                                        <small>Please Login or Register first, thank you.</small>

                                        <img
                                            src="{{asset('images/image5.png')}}"
                                            class="img-fluid h-100 mt-4"
                                            alt="..."
                                            style="object-fit: cover;">
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{ route('register') }}" class="btn btn-sm btn-outline-dark">Register</a>
                                        <a href="{{ route('login') }}" class="btn btn-sm btn-dark">Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endguest

                        @auth
                        <a href="" class="btn btn-sm btn-outline-dark">
                            <span>Profile</span>
                        </a>

                        <button class="btn btn-sm btn-dark">Message</button>
                        <button class="btn btn-sm btn-dark">Inquire</button>
                        <button class="btn btn-sm btn-dark">Contacts</button>
                        @endauth
                    </div>

                </div>
            </div>

            <div class="col-6">
                <div class="bg-light p-2 rounded w-100 d-flex justify-content-between align-items-center">
                    @php
                    $amenities = $property->amenities;

                    if (is_string($amenities)) {
                    // Try to decode JSON
                    $decoded = json_decode($amenities, true);

                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $amenities = $decoded; // Use decoded JSON
                    } else {
                    // Fallback: treat as comma-separated string
                    $amenities = array_map('trim', explode(',', $amenities));
                    }
                    }
                    @endphp

                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">
                            <i class="bi bi-stars me-1 text-primary"></i> Amenities
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            @forelse($amenities ?? [] as $amenity)
                            @if(!empty($amenity))
                            <span class="badge rounded-pill bg-light text-dark border px-3 py-2 shadow-sm">
                                <i class="bi bi-check-circle text-success me-1"></i> {{ $amenity }}
                            </span>
                            @endif
                            @empty
                            <span class="text-muted small">No amenities listed</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row my-2">
            <div class="col-6">

            </div>

            <div class="col-6">
                <div class="bg-light p-2 rounded">
                    @auth
                    <a href="" class="btn btn-sm btn-dark mb-2">
                        available route
                    </a>
                    @endauth

                    @guest
                    <button
                        class="btn btn-sm btn-dark mb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#available-route">
                        avaliable route
                    </button>

                    <div class="modal fade" id="available-route" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-body">
                                    <h6>Route feature is only available for registered user.</h6>
                                    <small>Please Login or Register first, thank you.</small>

                                    <img
                                        src="{{asset('images/image6.png')}}"
                                        class="img-fluid h-100 mt-4"
                                        alt="..."
                                        style="object-fit: cover;">
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ route('register') }}" class="btn btn-sm btn-outline-dark">Register</a>
                                    <a href="{{ route('login') }}" class="btn btn-sm btn-dark">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endguest
                    <!-- Map Section -->
                    <div class="w-100">
                        <div id="map" class="rounded" style="height: 200px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    let map;
    let marker;

    function initMap(lat = 14.5995, lng = 120.9842, title = 'Property') {
        const propertyLocation = {
            lat: parseFloat(lat),
            lng: parseFloat(lng)
        };

        if (!map) {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: propertyLocation,
                disableDefaultUI: true,

                styles: [{
                    elementType: "geometry",
                    stylers: [{
                        color: "#d9f5d6"
                    }] // pale cream background
                },
                {
                    elementType: "labels.icon",
                    stylers: [{
                        visibility: "off"
                    }]
                },
                {
                    elementType: "labels.text.fill",
                    stylers: [{
                        color: "#666666"
                    }]
                },
                {
                    featureType: "administrative.land_parcel",
                    stylers: [{
                        visibility: "off"
                    }]
                },
                {
                    featureType: "poi.park",
                    elementType: "geometry.fill",
                    stylers: [{
                        color: "#d9f5d6"
                    }] // pale green parks
                },
                {
                    featureType: "poi.school",
                    elementType: "geometry.fill",
                    stylers: [{
                        color: "#ffe6e6"
                    }] // soft pink schools/universities
                },
                {
                    featureType: "road",
                    elementType: "geometry",
                    stylers: [{
                        color: "#d9f5d6"
                    }] // clean white roads
                },
                {
                    featureType: "road.arterial",
                    elementType: "geometry",
                    stylers: [{
                        color: "#f7e9d7"
                    }] // pastel beige arterial roads
                },
                {
                    featureType: "road.highway",
                    elementType: "geometry.fill",
                    stylers: [{
                        color: "#f8d5a3"
                    }] // soft orange highways
                },
                {
                    featureType: "road.highway",
                    elementType: "geometry.stroke",
                    stylers: [{
                        color: "#eac086"
                    }]
                },
                {
                    featureType: "transit.line",
                    elementType: "geometry",
                    stylers: [{
                        color: "#e6d3f7"
                    }] // pale purple transit
                },
                {
                    featureType: "water",
                    elementType: "geometry.fill",
                    stylers: [{
                        color: "#b5e3f7"
                    }] // soft blue water
                }
            ]
            });
        } else {
            map.setCenter(propertyLocation);
        }

        if (marker) {
            marker.setMap(null);
        }

        marker = new google.maps.Marker({
            position: propertyLocation,
            map: map,
            title: title,
      
        });
    }

    // Run once when DOM is ready
    document.addEventListener('DOMContentLoaded', () => {
        initMap(
            {{ $property->latitude ?? 14.5995 }},
            {{ $property->longitude ?? 120.9842 }},
            "{{ $property->name }}"
        );
    });

    // Re-run every time Livewire updates this component
    document.addEventListener('livewire:navigated', () => {
        initMap(
            {{ $property->latitude ?? 14.5995 }},
            {{ $property->longitude ?? 120.9842 }},
            "{{ $property->name }}"
        );
    });
</script>
