<div class="overflow-hidden">
    <div class="vh-100 overflow-auto">
        <div class="container-fluid">
            <div class="row gx-3 mt-5">
                {{-- Profile Card --}}
                <div class="col-12">
                    <div class="profile-card position-relative">

                        <div class="d-flex flex-column align-items-center justify-content-center pt-4 pb-3">
                            <div class="mb-3">
                                {{-- Profile Image --}}
                                @if($host->profile_image)
                                <img
                                    src="{{ asset('storage/' . $host->profile_image) }}"
                                    alt="{{ $host->firstName }} {{ $host->lastName }}"
                                    class="rounded-circle object-fit-cover border border-3 border-white shadow"
                                    style="width: 120px; height: 120px;">
                                @else
                                @php
                                $initials = strtoupper(substr($host->firstName, 0, 1) . substr($host->lastName, 0, 1));
                                @endphp
                                <div class="rounded-circle d-flex justify-content-center align-items-center bg-dark text-white fw-bold border border-3 border-white shadow"
                                    style="width: 160px; height: 160px; font-size: 60px;">
                                    {{ $initials }}
                                </div>
                                @endif
                            </div>

                            <p class="fw-medium fs-5 text-center mb-0">
                                {{ ucfirst($host->firstName) }}
                                {{ ucfirst($host->lastName) }}
                            </p>

                            <div class="text-center mt-0 mb-4">
                                <span class="badge rounded-pill" style="background-color: #dcfce7; color: #166534; font-size: 11px; font-weight: 600; padding: 6px 12px;">
                                    <i class="fas fa-check-circle me-1" style="font-size: 10px;"></i>
                                    Verified Host
                                </span>
                            </div>

                            <div>
                                <button class="btn btn-sm btn-dark fw-medium"><small>connect</small></button>
                                <button class="btn btn-sm btn-outline-dark fw-medium"><small>message</small></button>
                                <button class="btn btn-sm btn-outline-danger fw-medium"><small>report</small></button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Properties Section --}}

                <div class="col-12 px-5 py-3 ">

                    @if($host->properties->count() > 0)
                    <div class="property-list">
                        <div class="row g-4">
                            @foreach($host->properties as $property)
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
                                                            alt="{{ $property->propertyName }}"
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
                                                ];

                                                $tenantType = $property->tenantType;
                                                $badgeColor = $tenantColors[$tenantType] ?? 'bg-dark';
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
                                                $maxLength = 25;
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
                                                $city = $address;

                                                $parts = array_map('trim', explode(',', $address));

                                                if (count($parts) >= 2) {
                                                $city = $parts[count($parts) - 3] ?? $parts[0];
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
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="bi bi-house-slash fs-1 text-muted mb-3 d-block"></i>
                        <p class="text-muted">This host hasn't listed any properties yet.</p>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>