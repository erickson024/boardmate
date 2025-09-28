<div class="container overflow-auto" style="height:80%;">
    <div class="row">
        <div class="col-12">

            <input type="hidden" id="latitude" wire:model="latitude">
            <input type="hidden" id="longitude" wire:model="longitude">

            {{-- Map container --}}
            <div class="position-relative" style="height: 330px; width: 100%;">
                <!-- Map -->
                <div wire:ignore id="map" class=" rounded" style="height: 100%; width: 100%;"></div>

                <!-- Input on top of map -->
                <div wire:key="field-address"
                    class="position-absolute top-0 start-50 translate-middle-x p-2 w-50"
                    style="width: 80%; z-index: 10;">

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
</div>


<script>
    let map, marker, autocomplete, geocoder, streetView;

    function initMap() {
        // Clear previous instances
        map = marker = autocomplete = geocoder = streetView = null;

        const mapDiv = document.getElementById("map");
        const input = document.getElementById("address-input");

        if (!mapDiv || !input || !google || !google.maps) {
            console.log("Map initialization failed - missing elements or Google Maps not loaded");
            return;
        }

        // Initialize map first
        map = new google.maps.Map(mapDiv, {
            center: {
                lat: 14.5995,
                lng: 120.9842
            },
            zoom: 13,
            streetViewControl: true,
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

        // Force a resize after map creation
        google.maps.event.trigger(map, 'resize');

        // Initialize other components
        marker = new google.maps.Marker({
            map,
            draggable: true
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

        // --- Autocomplete Listener ---
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            // Use custom formatter
            const formatted = formatAddress(place.address_components || []);
            updateMap(
                place.geometry.location.lat(),
                place.geometry.location.lng(),
                formatted,
                true
            );
        });

        // --- Marker Drag Listener---
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
                    // Use custom formatter
                    const formatted = formatAddress(results[0].address_components || []);
                    updateMap(lat, lng, formatted, true);
                }
            });
        });

        // --- Pegman (Street View Listner) ---
        streetView.addListener("position_changed", () => {
            const pos = streetView.getPosition();
            if (!pos) return;

            geocoder.geocode({
                location: pos
            }, (results, status) => {
                if (status === "OK" && results[0]) {
                    // Use custom formatter
                    const formatted = formatAddress(results[0].address_components || []);
                    updateMap(pos.lat(), pos.lng(), formatted, false);
                }
            });
        });
    }

    function updateMap(lat, lng, address, movePegman = false) {
        map.setCenter({
            lat,
            lng
        });
        map.setZoom(15);
        marker.setPosition({
            lat,
            lng
        });

        if (address) {
            document.getElementById("address-input").value = address;
        }

        if (movePegman) {
            streetView.setPosition({
                lat,
                lng
            });
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

        // Fallback if city is not found, use sublocality or similar
        if (!city) {
            const sublocality = components.find(comp => comp.types.includes('sublocality'));
            if (sublocality) city = sublocality.long_name;
        }

        return [city, province, country].filter(Boolean).join(', ');
    }

    // Single initialization function that checks prerequisites
    function safeInitMap() {
        if (document.getElementById("map") && typeof google !== "undefined" && google.maps) {
            initMap();
        } else {
            setTimeout(safeInitMap, 100);
        }
    }

    // Remove other listeners, use only Livewire's events
    document.addEventListener("livewire:navigated", () => {
        safeInitMap();
    });

    document.addEventListener("livewire:init", () => {
        safeInitMap();
    });

    // Listen for step changes from Livewire
    Livewire.on('stepChanged', (step) => {
        if (step === 1) {
            safeInitMap();
        }
    });
</script>