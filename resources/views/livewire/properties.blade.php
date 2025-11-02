<div>
    <div
        class="row overflow-hidden p-3 sticky-top d-flex justify-content-center "
        style="background-color: rgba(248, 249, 250, 0.75); top: 66px; z-index: 1020;">
        <div class="col-10">
           <livewire:property-search-bar />
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="sort" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-sm"><small>Search</small></button>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-3">
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
            $images = json_decode($property->images, true);
            $carouselId = 'carouselProperty' . $property->id;
            @endphp

            <div class="col-12 col-md-4 col-lg-3">
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

                                @php
                                $tenantColors = [
                                'Student' => 'bg-primary',
                                'Employee' => 'bg-success',
                                'Family' => 'bg-info',
                                'Couple' => 'bg-danger',
                                'Groups' => 'bg-danger',
                                'Single' => 'bg-success',
                                'Any' => 'bg-secondary',
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
                            {{-- Price --}}
                            <div class="d-flex justify-content-between align-items-center">
                                @php
                                $maxLength = 25; // maximum characters
                                $propertyName = $property->name;
                                $displayName = strlen($propertyName) > $maxLength ? substr($propertyName, 0, $maxLength) . '…' : $propertyName;
                                @endphp

                                <span class="card-title fw-medium mb-0">
                                    <small>{{ $displayName }}</small>
                                </span>
                            </div>

                            {{-- Property Name --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-medium small">₱{{ number_format($property->cost, 2) }}</span>

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

        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination pagination-dark justify-content-center">
                {{ $properties->onEachSide(1)->links('components.simple-pagination') }}
            </ul>
        </nav>

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
</div>