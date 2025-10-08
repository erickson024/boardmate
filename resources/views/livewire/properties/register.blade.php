<div class="container-fluid">
    <div class="row p-2 gx-3 rounded">
        <!--debug-->

        <!--indicator-->
        <div class="col-3 slide-in-left">
            <div class="bg-dark text-white rounded p-3 shadow h-100 d-flex flex-column justify-content-center align-items-start">
                <livewire:properties.indicator :currentStep="$currentStep" :totalSteps="4" />
            </div>
        </div>

        <div class="col-9 slide-in-up">
            <div class="bg-light p-4 shadow rounded " style="height: 470px;">
                <div class="row">
                    <div class="col-6">
                        <p class="fw-semibold fs-6 mb-4">Add Your Property</p>
                    </div>

                    <div class="col-6 d-flex justify-content-end">
                        <div class="gap-2">
                            <button class="btn btn-sm btn-dark">save</button>

                        </div>
                    </div>

                </div>
                <div id="map-container" class="{{ $currentStep === 2 ? '' : 'd-none' }}">
                    <div wire:ignore id="map" class=" rounded" style="height: 250px; width: 100%;"></div>

                    <div class="row mt-2">
                        <div class="col-12">

                            <input type="hidden" id="latitude" wire:model="latitude">
                            <input type="hidden" id="longitude" wire:model="longitude">


                            <!-- Input on top of map -->
                            <div wire:key="field-address"
                                class=""
                                style="width: 100%; z-index: 10;">

                                <div class="input-group shadow">
                                    <span class="input-group-text bg-white text-white border-0 px-3">
                                        <i class="bi bi-geo-alt-fill text-dark"></i>
                                    </span>
                                    <input
                                        type="text"
                                        class="form-control text-dark shadow-none fw-semibold border-0 p-3"
                                        placeholder="Enter your address"
                                        id="address-input"
                                        wire:model="address"
                                        style="font-size: 13px;"
                                        autocomplete="off"
                                        aria-describedby="basic-addon1">
                                </div>
                                @error('address')
                                <small class="text-danger d-block mt-1 bg-white p-2 rounded" style="font-size: 13px;">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Step Content -->
                @if ($currentStep === 1)
                @include('livewire.properties.steps.step-one')
                @elseif ($currentStep === 2)
                @include('livewire.properties.steps.step-two')
                @elseif ($currentStep === 3)
                @include('livewire.properties.steps.step-three')
                @elseif ($currentStep === 4)
                @include('livewire.properties.steps.step-four')
                @endif

                <!-- Navigation Buttons -->
                <div class="mt-2 d-flex justify-content-between">
                    @if ($currentStep > 1)
                    <button wire:click="previousStep" class="btn btn-outline-secondary fade-in">Back
                        <span class="spinner-border spinner-border-sm" wire:loading wire:target="previousStep"></span>
                    </button>

                    @else
                    <div></div>
                    @endif

                    @if ($currentStep < 4)
                        <button wire:click="nextStep" class="btn btn-dark">Continue
                        <span class="spinner-border spinner-border-sm" wire:loading wire:target="nextStep"></span>
                        </button>

                        @else
                        <button wire:click="submit"
                            class="btn btn-dark"
                            wire:loading.attr="disabled"
                            wire:target="submit">
                            <span>Register</span>
                            <span class="spinner-border spinner-border-sm"
                                role="status"
                                aria-hidden="true"
                                wire:loading
                                wire:target="submit"></span>
                        </button>
                        @endif

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let map, marker, autocomplete, geocoder, streetView;
    let lastLatLng = {
        lat: 14.5995,
        lng: 120.9842
    }; // Default Manila
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
                zoom: 13,
                streetViewControl: true,
                disableDefaultUI: true,
                styles: [ /* your styles here */ ]
            });

            marker = new google.maps.Marker({
                map,
                draggable: true,
                position: lastLatLng
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
        map.setZoom(15);
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
        let city = '';
        let province = '';
        let country = '';

        components.forEach(comp => {
            if (comp.types.includes('locality')) city = comp.long_name;
            if (comp.types.includes('administrative_area_level_1')) province = comp.long_name;
            if (comp.types.includes('country')) country = comp.long_name;
        });

        if (!city) {
            const sublocality = components.find(comp => comp.types.includes('sublocality'));
            if (sublocality) city = sublocality.long_name;
        }

        return [city, province, country].filter(Boolean).join(', ');
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