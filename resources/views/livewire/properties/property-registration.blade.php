<div class="container-fluid flex-grow-1 d-flex align-items-center justify-content-center">
    <div class="row w-100 justify-content-center mt-3">
        <div class="col-12 col-md-6">

            <div class="mb-3 d-flex justify-content-between">
                <button wire:click="goToHome" class="btn btn-dark fw-semibold btn-sm">
                    <i class="bi bi-arrow-left-short"></i>
                    <small>Boardmate Home</small>
                </button>

                <button class="btn btn-outline-dark fw-semibold btn-sm">
                    <small>Need Help?</small>
                </button>
            </div>

            <!-- Map Container -->
            <div id="map-container" class="{{ $currentStep === 2 ? '' : 'd-none' }}">
                <div class="row gap-2  d-flex justify-content-center">
                    <div class="col-12">
                        <p class="fs-6 fw-semibold text-start mb-0">Enter the full address of the property so tenants can locate it easily.</p>
                        <small class="mt-0">You may drag the Pegman to save the exact location of your property.</small>
                    </div>

                    <div class="col-12 position-relative mt-3">
                        <!-- Map -->
                        <div wire:ignore id="map" class="rounded" style="height: 330px; width: 100%;"></div>

                        <!-- Input on top of map -->
                        <div wire:key="field-address"
                            class="position-absolute top-0 start-50 translate-middle-x w-75 px-2"
                            style="z-index: 10; margin-top: 10px;">
                            <div class="input-group shadow">
                                <span class="input-group-text bg-light-subtle text-white border-0 px-3">
                                    <i class="bi bi-geo-alt-fill text-dark"></i>
                                </span>
                                <input
                                    type="text"
                                    class="form-control text-dark shadow-none fw-semibold border-0 p-3 "
                                    placeholder="Enter your address"
                                    id="address-input"
                                    wire:model="address"
                                    style="font-size: 13px;"
                                    autocomplete="off"
                                    aria-describedby="basic-addon1"
                                    required>
                            </div>
                            @error('address')
                            <small class="text-danger d-block mt-1 bg-white p-2 rounded" style="font-size: 13px;">{{ $message }}</small>
                            @enderror
                        </div>

                        <input type="hidden" id="latitude" wire:model="latitude">
                        <input type="hidden" id="longitude" wire:model="longitude">
                    </div>
                </div>
            </div>

            <!-- Step Content -->
            <div class="mb-3">
                @if ($currentStep === 1)
                <livewire:properties.step1-basic-information />
                @elseif ($currentStep === 2)
                <livewire:properties.step2-address-map />
                @elseif ($currentStep === 3)
                <livewire:properties.step3-features />
                @elseif ($currentStep === 4)
                <livewire:properties.step4-restiction />
                @endif
            </div>

        </div>
    </div>


    <div class="position-fixed bottom-0 start-50 translate-middle-x w-100 bg-white p-2">
        <div class="d-flex justify-content-center gap-2">
            <div class="progress" style="height: 2px; width: 16%;">
                <div class="progress-bar {{ $currentStep >= 1 ? 'bg-dark' : 'bg-secondary' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 16%;">
                <div class="progress-bar {{ $currentStep >= 2 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 16%;">
                <div class="progress-bar {{ $currentStep >= 3 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 16%;">
                <div class="progress-bar {{ $currentStep >= 4 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 16%;">
                <div class="progress-bar {{ $currentStep >= 5 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 16%;">
                <div class="progress-bar {{ $currentStep >= 6 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <script>
        let map, marker, autocomplete, geocoder, streetView;
        let lastLatLng = {
            lat: 14.5547,
            lng: 121.0244
        }; // Default Makati
        let lastAddress = "";

        function initMap() {
            const mapDiv = document.getElementById("map");
            const input = document.getElementById("address-input");

            if (!mapDiv || !input || !google || !google.maps) {
                console.log("Map initialization failed - missing elements or Google Maps not loaded");
                return;
            }

            if (!map) {
                // Initialize only once
                map = new google.maps.Map(mapDiv, {
                    center: lastLatLng,
                    zoom: 14,
                    streetViewControl: true,
                    disableDefaultUI: true,
                    styles: [ /* your styles here */ ]
                });

                marker = new google.maps.Marker({
                    map,
                    draggable: true,
                    position: lastLatLng,
                    animation: google.maps.Animation.DROP,

                });

                geocoder = new google.maps.Geocoder();
                streetView = map.getStreetView();

                // Initialize autocomplete last
                autocomplete = new google.maps.places.Autocomplete(input, {
                    types: ['geocode'],
                    componentRestrictions: {
                        country: "ph"
                    }
                });

                // === LISTENERS ===
                autocomplete.addListener("place_changed", () => {
                    const place = autocomplete.getPlace();
                    if (!place.geometry) return;

                    const formatted = formatAddress(place.address_components || []);
                    updateMap(place.geometry.location.lat(), place.geometry.location.lng(), formatted, true);
                });

                google.maps.event.addListener(marker, "dragend", (event) => {
                    const lat = event.latLng.lat();
                    const lng = event.latLng.lng();
                    geocoder.geocode({
                        location: {
                            lat,
                            lng
                        }
                    }, (results, status) => {
                        if (status === "OK" && results[0]) {
                            const formatted = formatAddress(results[0].address_components || []);
                            updateMap(lat, lng, formatted, true);
                        }
                    });
                });

                streetView.addListener("position_changed", () => {
                    const pos = streetView.getPosition();
                    if (!pos) return;
                    geocoder.geocode({
                        location: pos
                    }, (results, status) => {
                        if (status === "OK" && results[0]) {
                            const formatted = formatAddress(results[0].address_components || []);
                            updateMap(pos.lat(), pos.lng(), formatted, false);
                        }
                    });
                });
            } else {
                // Just refresh when map is shown again
                google.maps.event.trigger(map, "resize");
                map.setCenter(lastLatLng);
                marker.setPosition(lastLatLng);
                if (lastAddress) {
                    input.value = lastAddress;
                }
            }
        }

        function updateMap(lat, lng, address, movePegman = false) {
            lastLatLng = {
                lat,
                lng
            };
            lastAddress = address;

            map.setCenter(lastLatLng);
            map.setZoom(14);
            marker.setPosition(lastLatLng);

            if (address) {
                document.getElementById("address-input").value = address;
            }

            if (movePegman) {
                streetView.setPosition(lastLatLng);
            }

            Livewire.dispatch("setAddress", {
                address,
                lat,
                lng
            });
        }

        function formatAddress(components) {
            let street = '';
            let city = '';
            let province = '';
            let country = '';

            components.forEach(comp => {
                if (comp.types.includes('street_number')) street = comp.long_name;
                if (comp.types.includes('route')) street += ' ' + comp.long_name;
                if (comp.types.includes('locality')) city = comp.long_name;
                if (comp.types.includes('administrative_area_level_1')) province = comp.long_name;
                if (comp.types.includes('country')) country = comp.long_name;
            });

            if (!city) {
                const sublocality = components.find(comp => comp.types.includes('sublocality'));
                if (sublocality) city = sublocality.long_name;
            }

            return [street.trim(), city, province, country].filter(Boolean).join(', ');
        }

        function safeInitMap() {
            if (document.getElementById("map") && typeof google !== "undefined" && google.maps) {
                initMap();
            } else {
                setTimeout(safeInitMap, 100);
            }
        }

        document.addEventListener("livewire:init", () => {
            if (document.getElementById("map")) {
                safeInitMap();
            }
        });

        Livewire.on("stepChanged", (step) => {
            if (step === 2) {
                safeInitMap();
            }
        });
    </script>
</div>