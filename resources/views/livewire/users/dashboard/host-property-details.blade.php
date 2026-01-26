<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-3 sticky-top ">
        <div class="col-12">
            <div class="bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-row gap-2">
                        <a
                            href="{{ route('user.dashboard') }}?currentTab=property-list"
                            wire:navigate class="btn btn-sm btn-dark px-2 fw-medium d-flex align-items-center justify-content-center">
                            <i class="bi bi-arrow-bar-left"></i>
                        </a>
                        <div class="d-flex flex-column">
                            <h5 class="mb-0 fw-semibold text-truncate">{{ $propertyName }} Details</h5>
                            <small class="text-muted">Manage listing, photos, and availability</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button
                            type="button"
                            class="btn btn-sm btn-outline-dark rounded-3 d-flex align-items-center"
                            data-bs-toggle="modal"
                            data-bs-target="#deletePropertyModal"
                            aria-label="Delete property">
                            <small class="fw-semibold">
                                <i class="fa-solid fa-trash me-1"></i>
                                <span class="d-none d-md-inline">Delete</span>
                            </small>
                        </button>

                        <button
                            wire:click="saveChanges"
                            class="btn btn-sm btn-dark rounded-3 d-flex align-items-center"
                            id="saveChangesBtn"
                            aria-live="polite">
                            <small class="fw-semibold">
                                <i class="fa-solid fa-save me-2"></i>
                                <span>Save Changes</span>
                            </small>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Flash Messages -->
    @if(session()->has('success'))
    <div class="container mt-2">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if(session()->has('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <div class="container">
        <div class="row mb-5">
            <!-- basic information -->
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <h6 class="fw-semibold mb-1">Basic Information</h6>
                    <small class="text-muted d-block">
                        Essential details of your property including name, type, and pricing.
                    </small>
                </div>
                <div class="row mb-3 gx-3">
                    <!--Property Name-->
                    <div class="col-12 col-md-6">
                        <x-floating-labels.input
                            id="propertyName"
                            label="Property Name"
                            type="text"
                            wire:model="propertyName"
                            required />
                    </div>
                    <!-- Property Cost -->
                    <div class="col-12 col-md-6">
                        <x-floating-labels.input
                            id="propertyCost"
                            label="Monthly Cost (₱)"
                            type="number"
                            wire:model="propertyCost"
                            required />
                    </div>
                </div>

                <div class="row">
                    <!-- Property Type -->
                    <div class="col-12 mb-3">
                        <div x-data="{ selected: @entangle('propertyType').live }" class="row g-2">
                            @foreach($propertyTypes as $key => $label)
                            <div class="col-4" wire:key="property-type-{{ $key }}">
                                <button
                                    type="button"
                                    @click="selected === '{{ $key }}' ? selected = '' : selected = '{{ $key }}'"
                                    :class="selected === '{{ $key }}'
                                                ? 'bg-secondary text-white border-secondary shadow'
                                                : 'bg-white text-secondary border-secondary'"
                                    class="d-flex flex-column align-items-center justify-content-center text-center border rounded w-100 py-3"
                                    style="transition: all 0.2s;">
                                    <i class="bi {{ $propertyTypeIcons[$key] ?? 'bi-building' }} fs-4 mb-1"
                                        :class="selected === '{{ $key }}' ? 'text-white' : 'text-secondary'"></i>
                                    <span class="fw-medium small">{{ $label }}</span>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <x-floating-labels.text-area
                                label="Property Description"
                                id="propertyDescription"
                                wire:model="propertyDescription"
                                height="200" />
                        </div>
                    </div>
                </div>


            </div>

            <!-- Address / Mappings -->
            <div class="col-12 col-md-6 ">
                <div class="mb-3">
                    <h6 class="fw-semibold mb-1">Property Location</h6>
                    <small
                        class="text-muted d-block">Enter the full address so tenants can locate it easily. You can drag the marker for precise positioning.
                    </small>
                </div>
                <div class="mb-3" wire:ignore>
                    <div class="position-relative">
                        <x-floating-labels.input
                            type="text"
                            label="address"
                            id="address-input"
                            autocomplete="off" />

                        <div class="position-absolute top-50 end-0 translate-middle-y me-3" id="address-status"></div>
                    </div>

                    <div id="address-helper" class="mt-2 small" style="display: none;">
                        <i class="bi bi-exclamation-circle me-1"></i>
                        <span id="helper-text">Please enter and select an address from the dropdown</span>
                    </div>
                </div>

                <div wire:ignore>
                    <div class="position-relative map-container" id="map-container" style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <div id="map" style="height: 390px; width: 100%;"></div>

                        <!-- Success badge -->
                        <div id="location-success" class="position-absolute top-0 start-0 m-3 bg-success text-white rounded-3 shadow-sm px-3 py-2" style="display: none;">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <small class="fw-semibold">Location Updated</small>
                        </div>

                        <!-- Map controls -->
                        <div class="position-absolute top-0 end-0 m-3 d-flex flex-column gap-2">
                            <button id="recenter-btn" class="btn btn-light rounded-circle shadow-sm" style="width: 44px; height: 44px;" title="Recenter map">
                                <i class="bi bi-crosshair"></i>
                            </button>
                            <button id="satellite-toggle" class="btn btn-light rounded-circle shadow-sm" style="width: 44px; height: 44px;" title="Toggle satellite view">
                                <i class="bi bi-globe"></i>
                            </button>
                        </div>

                        <!-- Coordinates display -->
                        <div class="position-absolute bottom-0 start-0 m-3 bg-white rounded-2 shadow-sm px-3 py-2" style="font-size: 11px;" id="coords-display">
                            <span class="text-muted">Lat:</span> <span id="lat-display" class="fw-semibold">{{ $latitude ?: '—' }}</span>
                            <span class="text-muted ms-2">Lng:</span> <span id="lng-display" class="fw-semibold">{{ $longitude ?: '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <!-- Features -->
            <div class="col-12 mb-5">
                <div class="mb-3">
                    <h6 class="fw-semibold">Property Features</h6>
                    <small class="text-muted mb-2 d-block">
                        These are the house rules that tenants must follow while staying at the property.
                        Please review them carefully before submitting your listing.
                    </small>
                </div>

                <div x-data="{ selected: @entangle('propertyFeatures') }" class="row g-2">
                    @foreach($propertyFeatureIcons as $key => $icon)
                    @php
                    $colorClass = $featureColors[$key] ?? 'bg-secondary';
                    $borderColorClass = str_replace('bg-', 'border-', $colorClass);
                    @endphp

                    <div class="col-auto" wire:key="property-feature-{{ $key }}">
                        <button
                            type="button"
                            @click="
                                            if(selected.includes('{{ $key }}')){
                                                selected = selected.filter(f => f !== '{{ $key }}')
                                            } else {
                                                selected.push('{{ $key }}')
                                            }"
                            :class="selected.includes('{{ $key }}')
                                            ? '{{ $colorClass }} text-white {{ $borderColorClass }} shadow-sm'
                                            : 'bg-white text-dark {{ $borderColorClass }} shadow-sm'"
                            class="d-flex flex-column align-items-center justify-content-center text-center border rounded"
                            style="width: 110px; height: 90px; transition: all 0.2s;">
                            <i class="{{ $icon }} fs-4 mb-2"
                                :class="selected.includes('{{ $key }}') ? 'text-white' : 'text-{{ str_replace('bg-', '', $colorClass) }}'"></i>
                            <span class="fw-medium small"
                                :class="selected.includes('{{ $key }}') ? 'text-white' : 'text-dark'"
                                style="font-size: 0.7rem; line-height: 1.1;">
                                {{ $key }}
                            </span>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Restrictions -->
            <div class="col-12">
                <div class="mb-3">
                    <h6 class="fw-semibold">Property Restrictions</h6>
                    <small class="text-muted mb-2 d-block">
                        Select the features available in your property. Click on each feature to include it in your listing.
                    </small>
                </div>

                <div x-data="{ selected: @entangle('propertyRestrictions') }" class="row g-2">
                    @foreach($propertyRestrictionIcons as $key => $icon)
                    <div class="col-auto" wire:key="property-restriction-{{ $key }}">
                        <button
                            type="button"
                            @click="
                                            if(selected.includes('{{ $key }}')){
                                                selected = selected.filter(r => r !== '{{ $key }}')
                                            } else {
                                                selected.push('{{ $key }}')
                                            }"
                            :class="selected.includes('{{ $key }}')
                                            ? 'bg-danger text-white border-danger shadow-sm'
                                            : 'bg-white text-dark border-danger shadow-sm'"
                            class="d-flex flex-column align-items-center justify-content-center text-center border rounded"
                            style="width: 110px; height: 90px; transition: all 0.2s;">
                            <i class="{{ $icon }} fs-4 mb-2"
                                :class="selected.includes('{{ $key }}') ? 'text-white' : 'text-danger'"></i>
                            <span class="fw-medium small"
                                :class="selected.includes('{{ $key }}') ? 'text-white' : 'text-dark'"
                                style="font-size: 0.7rem; line-height: 1.1;">
                                {{ $key }}
                            </span>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <!-- Tenant Gender -->
            <div class="col-6">
                <div class="mb-3">
                    <h6 class="fw-semibold">Preferable Tenant Gender</h6>
                    <small class="text-muted mb-2 d-block">
                        Select your preferable tenant gender for this property.
                    </small>
                </div>

                <div x-data="{ selected: @entangle('tenantGender').live }" class="row g-2 mb-3">
                    @foreach($genders as $key => $genderOption)
                    <div class="col-4" wire:key="gender-{{ $key }}">
                        <button
                            type="button"
                            @click="selected === '{{ $key }}' ? selected = '' : selected = '{{ $key }}'"
                            class="d-flex flex-column align-items-center justify-content-center text-center border rounded-3 position-relative w-100 py-3"
                            :class="selected === '{{ $key }}' 
                                                    ? 'bg-dark border-dark shadow' 
                                                    : 'bg-white border-secondary'"
                            style="transition: all 0.2s;">

                            <!-- Checkmark -->
                            <i class="bi bi-check-circle-fill position-absolute top-0 end-0 m-1 rounded-circle text-light"
                                :class="selected === '{{ $key }}' ? 'd-inline-block' : 'd-none'"
                                style="font-size: 0.9rem;"></i>

                            <!-- Icon -->
                            <i class="{{ $genderOption['icon'] }} fs-4 mb-1"
                                :class="selected === '{{ $key }}' ? 'text-white' : 'text-dark'"></i>

                            <!-- Label -->
                            <span class="fw-medium small"
                                :class="selected === '{{ $key }}' ? 'text-white' : 'text-dark'">
                                {{ $genderOption['label'] }}
                            </span>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Tenant Type -->
            <div class="col-6">
                <div class="mb-3">
                    <h6 class="fw-semibold">Preferable Tenant Type</h6>
                    <small class="text-muted mb-2 d-block">
                        Select the type of tenants allowed to rent this property.
                    </small>
                </div>
                <div x-data="{ selected: @entangle('tenantType').live }" class="row g-2">
                    @foreach($types as $key => $type)
                    <div class="col-3" wire:key="type-{{ $key }}">
                        <button
                            type="button"
                            @click="selected === '{{ $key }}' ? selected = '' : selected = '{{ $key }}'"
                            class="d-flex flex-column align-items-center justify-content-center text-center border rounded-3 position-relative w-100 py-3"
                            :class="selected === '{{ $key }}' 
                                                    ? 'bg-{{ $type['color'] }} border-{{ $type['color'] }} shadow' 
                                                    : 'bg-white border-secondary'"
                            style="transition: all 0.2s;">

                            <!-- Icon -->
                            <i class="{{ $type['icon'] }} fs-5 mb-1"
                                :class="selected === '{{ $key }}' ? 'text-white' : 'text-{{ $type['color'] }}'"></i>

                            <!-- Label -->
                            <span class="fw-medium small"
                                :class="selected === '{{ $key }}' ? 'text-white' : 'text-dark'"
                                style="font-size: 0.75rem;">
                                {{ $type['label'] }}
                            </span>

                            <!-- Checkmark -->
                            <i class="bi bi-check-circle-fill position-absolute top-0 end-0 m-1 rounded-circle text-light"
                                :class="selected === '{{ $key }}' ? 'd-inline-block' : 'd-none'"
                                style="font-size: 0.9rem;"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <!-- Property Photos -->
            <div class="col-12" x-data="{ isDragging: false }">

                {{-- Header --}}
                <div class="mb-3">
                    <h6 class="fw-semibold mb-1">Property Photos</h6>
                    <small class="text-muted">
                        Upload clear, well-lit images of your property. Show different angles and important features.
                    </small>
                </div>

                {{-- Image Counter --}}
                <div class="mb-3 d-flex align-items-center gap-2">
                    <span class="badge rounded-pill {{ count($images) >= 1 ? 'bg-success' : 'bg-secondary' }}">
                        {{ count($images) + count($newImages) }} / 5 images
                    </span>

                    @if(count($images) + count($newImages) === 0)
                    <small class="text-muted">Upload at least 1 image</small>
                    @elseif(count($images) + count($newImages) < 5)
                        <small class="text-success">
                        <i class="bi bi-check-circle-fill"></i>
                        You can add {{ 5 - count($images) - count($newImages) }} more
                        </small>
                        @else
                        <small class="text-info">
                            <i class="bi bi-star-fill"></i> Maximum reached
                        </small>
                        @endif
                </div>

                {{-- Upload Progress --}}
                <div wire:loading wire:target="newImages" class="mb-3">
                    <div class="alert alert-primary border-0 py-2 d-flex align-items-center">
                        <div class="spinner-border spinner-border-sm me-2"></div>
                        <small>Uploading images<span class="loading-dots"></span></small>
                    </div>
                </div>

                {{-- Image Previews (Existing + New) --}}
                @if(count($images) || count($newImages))
                <div class="mb-4">
                    <div class="row g-3">

                        {{-- Existing Images --}}
                        @foreach ($images as $key => $image)
                        <div class="col-6 col-md-4" wire:key="existing-{{ $key }}" x-data="{ hover: false }">
                            <div class="preview-card position-relative rounded-3 overflow-hidden border shadow-sm"
                                @mouseenter="hover=true" @mouseleave="hover=false">
                                <div class="ratio ratio-4x3">
                                    <img src="{{ asset('storage/'.$image) }}" class="object-fit-cover w-100 h-100">
                                </div>

                                <span class="badge bg-dark position-absolute top-0 start-0 m-2">
                                    {{ $key + 1 }}
                                </span>

                                @if($key === 0)
                                <span class="badge bg-primary position-absolute bottom-0 start-0 m-2">
                                    <i class="bi bi-star-fill"></i> Cover
                                </span>
                                @endif

                                <button x-show="hover"
                                    x-transition
                                    wire:click="removeExistingImage({{ $key }})"
                                    class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 m-2"
                                    style="width:40px;height:40px">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach

                        {{-- New Images --}}
                        @foreach ($newImages as $index => $image)
                        <div class="col-6 col-md-4" wire:key="new-{{ $index }}" x-data="{ hover: false }">
                            <div class="preview-card position-relative rounded-3 overflow-hidden border border-primary shadow-sm"
                                @mouseenter="hover=true" @mouseleave="hover=false">
                                <div class="ratio ratio-4x3">
                                    <img src="{{ $image->temporaryUrl() }}" class="object-fit-cover w-100 h-100">
                                </div>

                                <span class="badge bg-primary position-absolute top-0 start-0 m-2">
                                    New
                                </span>

                                <button x-show="hover"
                                    x-transition
                                    wire:click="removeNewImage({{ $index }})"
                                    class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 m-2"
                                    style="width:40px;height:40px">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                @endif

                {{-- Upload Box / Done State --}}
                @if(count($images) + count($newImages) < 5)
                    <label for="property-images"
                    @dragover.prevent="isDragging=true"
                    @dragleave.prevent="isDragging=false"
                    @drop.prevent="isDragging=false"
                    :class="isDragging ? 'border-primary bg-primary bg-opacity-10' : 'border-secondary'"
                    class="upload-box border border-2 border-dashed rounded-4 p-5 text-center w-100">

                    <i class="bi fs-1 d-block mb-2"
                        :class="isDragging ? 'bi-cloud-check-fill text-primary' : 'bi-cloud-arrow-up text-muted'"></i>

                    <p class="fw-semibold mb-1" x-show="!isDragging">
                        Click to upload or drag and drop
                    </p>
                    <p class="fw-semibold text-primary mb-1" x-show="isDragging">
                        Drop images here
                    </p>

                    <small class="text-muted d-block">
                        JPG, PNG, WEBP • Max 2MB
                    </small>
                    </label>

                    <input type="file" id="property-images" class="d-none"
                        multiple wire:model="newImages"
                        accept="image/jpeg,image/png,image/webp">
                    @else
                    <div class="alert alert-success text-center py-4">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                        <strong class="d-block mt-1">All set!</strong>
                        <small>You’ve uploaded the maximum of 5 images</small>
                    </div>
                    @endif

                    {{-- Tips (only when empty) --}}
                    @if(!count($images) && !count($newImages))
                    <div class="alert alert-light border mt-4">
                        <small class="fw-semibold d-block mb-2">
                            <i class="bi bi-lightbulb text-warning"></i> Photography Tips
                        </small>
                        <ul class="small ps-3 mb-0">
                            <li>Use natural lighting</li>
                            <li>Show multiple angles</li>
                            <li>Highlight key areas</li>
                            <li>Keep rooms clean</li>
                        </ul>
                    </div>
                    @endif

                    {{-- Errors --}}
                    @error('newImages')
                    <div class="alert alert-danger mt-3 small">{{ $message }}</div>
                    @enderror

                    @error('newImages.*')
                    <div class="alert alert-danger mt-2 small">{{ $message }}</div>
                    @enderror

            </div>
        </div>

        <div class="row mb-5">
            <!--Terms and Condition-->
            <div class="col-12">
                <div class="mb-3">
                    <div class="mb-3">
                        <x-floating-labels.text-area
                            label="Property Terms and Condition"
                            id="terms"
                            wire:model="terms"
                            height="200" />
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Hidden inputs for Livewire binding -->
    <input type="hidden" wire:model="address">
    <input type="hidden" wire:model="latitude">
    <input type="hidden" wire:model="longitude">

    <!-- Delete Confirmation Modal -->
    <x-modal.backdrop id="deletePropertyModal">

        <div class="text-center py-3">
            <div class="mb-3">
                <i class="fa-solid fa-triangle-exclamation text-danger" style="font-size: 3rem;"></i>
            </div>
            <h5 class="fw-semibold mb-2">Delete "{{ $propertyName }}"?</h5>
            <p class="text-muted mb-0">This action cannot be undone. All property data, images, and associated information will be permanently deleted.</p>
        </div>

        <x-slot:footer>
            <button type="button" class="btn btn-sm btn-secondary rounded-3" data-bs-dismiss="modal">
                <i class="fa-solid fa-times me-1"></i>
                <small>Cancel</small>
            </button>
            <button
                type="button"
                wire:click="deleteProperty"
                class="btn btn-sm btn-danger rounded-3"
                data-bs-dismiss="modal">
                <i class="fa-solid fa-trash me-1"></i>
                <small>Yes, Delete Property</small>
            </button>
        </x-slot:footer>
    </x-modal.backdrop>

    <script>
        (function() {
            let map, marker, autocomplete, geocoder, streetView;
            let lastLatLng = {
                lat: 14.5547,
                lng: 121.0244
            };
            let mapInitialized = false;
            let isSatellite = false;
            let hasValidLocation = false;

            const mapStyles = [{
                    featureType: "all",
                    elementType: "geometry",
                    stylers: [{
                        color: "#f5f5f5"
                    }]
                },
                {
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [{
                        color: "#c9e9f6"
                    }]
                },
                {
                    featureType: "road",
                    elementType: "geometry",
                    stylers: [{
                        color: "#ffffff"
                    }]
                },
                {
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [{
                        visibility: "off"
                    }]
                }
            ];

            function initMap() {
                const mapDiv = document.getElementById('map');
                const input = document.getElementById('address-input');

                if (!mapDiv || !input || !window.google || !window.google.maps) return;

                if (!mapInitialized) {
                    // Load saved location first
                    loadSavedLocation();

                    map = new google.maps.Map(mapDiv, {
                        center: lastLatLng,
                        zoom: hasValidLocation ? 15 : 13,
                        styles: mapStyles,
                        disableDefaultUI: true,
                        streetViewControl: true,
                        zoomControl: false,
                        mapTypeControl: false,
                        fullscreenControl: false,
                        gestureHandling: 'greedy'
                    });

                    marker = new google.maps.Marker({
                        map,
                        position: lastLatLng,
                        draggable: true,
                        animation: google.maps.Animation.DROP,
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 12,
                            fillColor: "#dc3545",
                            fillOpacity: 1,
                            strokeColor: "#ffffff",
                            strokeWeight: 3
                        }
                    });

                    geocoder = new google.maps.Geocoder();
                    streetView = map.getStreetView();

                    marker.addListener('dragend', e => reverseGeocode(e.latLng));

                    streetView.addListener('position_changed', () => {
                        const pos = streetView.getPosition();
                        if (pos) reverseGeocode(pos);
                    });

                    setupCustomControls();
                    mapInitialized = true;
                    updateCoordinatesDisplay(lastLatLng.lat, lastLatLng.lng);
                }

                initAutocomplete(input);
            }

            function loadSavedLocation() {
                const addressInput = document.querySelector('input[wire\\:model="address"]');
                const latInput = document.querySelector('input[wire\\:model="latitude"]');
                const lngInput = document.querySelector('input[wire\\:model="longitude"]');

                if (addressInput && latInput && lngInput) {
                    const savedAddress = addressInput.value;
                    const savedLat = parseFloat(latInput.value);
                    const savedLng = parseFloat(lngInput.value);

                    if (savedAddress && !isNaN(savedLat) && !isNaN(savedLng)) {
                        lastLatLng = {
                            lat: savedLat,
                            lng: savedLng
                        };
                        hasValidLocation = true;

                        const input = document.getElementById('address-input');
                        if (input) {
                            input.value = savedAddress;
                        }
                    }
                }
            }

            function setupCustomControls() {
                const recenterBtn = document.getElementById('recenter-btn');
                const satelliteBtn = document.getElementById('satellite-toggle');

                if (recenterBtn) {
                    recenterBtn.addEventListener('click', () => {
                        map.setCenter(lastLatLng);
                        map.setZoom(15);
                    });
                }

                if (satelliteBtn) {
                    satelliteBtn.addEventListener('click', () => {
                        isSatellite = !isSatellite;
                        map.setMapTypeId(isSatellite ? 'satellite' : 'roadmap');
                        satelliteBtn.querySelector('i').className = isSatellite ? 'bi bi-map' : 'bi bi-globe';
                    });
                }
            }

            function initAutocomplete(input) {
                if (!input || !window.google || !window.google.maps) return;

                if (autocomplete) {
                    google.maps.event.clearInstanceListeners(autocomplete);
                }

                autocomplete = new google.maps.places.Autocomplete(input, {
                    componentRestrictions: {
                        country: 'ph'
                    },
                    types: ['geocode'],
                });

                autocomplete.addListener('place_changed', () => {
                    const place = autocomplete.getPlace();
                    if (!place.geometry) {
                        showValidationState('error', 'Please select a valid address from the dropdown');
                        return;
                    }

                    updateMap(
                        place.geometry.location.lat(),
                        place.geometry.location.lng(),
                        formatAddress(place.address_components),
                        true
                    );
                });
            }

            function reverseGeocode(latLng) {
                if (!geocoder) return;

                geocoder.geocode({
                    location: latLng
                }, (results, status) => {
                    if (status === 'OK' && results[0]) {
                        updateMap(
                            latLng.lat(),
                            latLng.lng(),
                            formatAddress(results[0].address_components),
                            false
                        );
                    }
                });
            }

            function updateMap(lat, lng, address, movePegman) {
                lastLatLng = {
                    lat,
                    lng
                };
                hasValidLocation = true;

                if (map) {
                    map.panTo(lastLatLng);
                    marker.setPosition(lastLatLng);
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                    setTimeout(() => marker.setAnimation(null), 1500);
                }

                const input = document.getElementById('address-input');
                if (input) input.value = address;

                if (movePegman && streetView) {
                    streetView.setPosition(lastLatLng);
                }

                updateCoordinatesDisplay(lat, lng);
                showValidationState('success', 'Location updated successfully');
                showLocationSuccess();

                if (window.Livewire) {
                    @this.set('address', address);
                    @this.set('latitude', lat);
                    @this.set('longitude', lng);
                }
            }

            function formatAddress(components = []) {
                let street = '',
                    city = '',
                    province = '',
                    country = '';

                components.forEach(c => {
                    if (c.types.includes('street_number')) street = c.long_name;
                    if (c.types.includes('route')) street += ' ' + c.long_name;
                    if (c.types.includes('locality')) city = c.long_name;
                    if (c.types.includes('administrative_area_level_1')) province = c.long_name;
                    if (c.types.includes('country')) country = c.long_name;
                });

                return [street.trim(), city, province, country].filter(Boolean).join(', ');
            }

            function updateCoordinatesDisplay(lat, lng) {
                const latDisplay = document.getElementById('lat-display');
                const lngDisplay = document.getElementById('lng-display');

                if (latDisplay) latDisplay.textContent = lat.toFixed(6);
                if (lngDisplay) lngDisplay.textContent = lng.toFixed(6);
            }

            function showValidationState(type, message) {
                const helper = document.getElementById('address-helper');
                const helperText = document.getElementById('helper-text');
                const statusEl = document.getElementById('address-status');

                if (!helper || !helperText) return;

                helper.style.display = 'block';
                helperText.textContent = message;
                helper.className = 'mt-2 small';

                if (type === 'success') {
                    helper.classList.add('text-success');
                    if (statusEl) statusEl.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
                    setTimeout(() => {
                        helper.style.display = 'none';
                        if (statusEl) statusEl.innerHTML = '';
                    }, 3000);
                } else if (type === 'error') {
                    helper.classList.add('text-danger');
                    if (statusEl) statusEl.innerHTML = '<i class="bi bi-x-circle-fill text-danger"></i>';
                }
            }

            function showLocationSuccess() {
                const success = document.getElementById('location-success');
                if (success) {
                    success.style.display = 'block';
                    setTimeout(() => {
                        success.style.opacity = '0';
                        success.style.transition = 'opacity 0.3s';
                        setTimeout(() => {
                            success.style.display = 'none';
                            success.style.opacity = '1';
                        }, 300);
                    }, 2000);
                }
            }

            function tryInitMap() {
                if (window.google && window.google.maps) {
                    setTimeout(initMap, 100);
                }
            }

            document.addEventListener('livewire:initialized', tryInitMap);
            document.addEventListener('google-maps-ready', tryInitMap);

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', tryInitMap);
            } else {
                tryInitMap();
            }
        })();
    </script>
</div>