<div class="container overflow-auto" style="height:80%;">
    <div class="row">
        <div class="col-12">

            <input type="hidden" id="latitude" wire:model="latitude">
            <input type="hidden" id="longitude" wire:model="longitude">

            {{-- ✅ Map container --}}

            <div id="map" wire:ignore style="height: 250px; width: 100%;" class="shadow rounded"></div>


            <div class="form-floating mt-3" wire:key="field-address">
                <input
                    type="text"
                    class="form-control border-dark text-dark shadow-none"
                    placeholder="Address"
                    id="address-input"
                    wire:model="address">
                <label class="text-dark">Property Address</label>
                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
    </div>
</div>

<script>
    let map, marker, autocomplete, geocoder, streetView;

    function initAutocomplete() {
        const input = document.getElementById("address-input");
        if (!input) return;

        // Autocomplete
        autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['geocode'],
            componentRestrictions: {
                country: "ph"
            }
        });

        // Map
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: 14.5995,
                lng: 120.9842
            }, // Manila
            zoom: 13,
            streetViewControl: true,
        });

        // Marker
        marker = new google.maps.Marker({
            map,
            draggable: true,
        });

        geocoder = new google.maps.Geocoder();
        streetView = map.getStreetView();

        // --- Autocomplete Listener ---
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            updateMap(
                place.geometry.location.lat(),
                place.geometry.location.lng(),
                place.formatted_address,
                true
            );
        });

        // --- Marker Drag ---
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
                    updateMap(lat, lng, results[0].formatted_address, true);
                }
            });
        });

        // --- Pegman ---
        streetView.addListener("position_changed", () => {
            const pos = streetView.getPosition();
            if (!pos) return;

            geocoder.geocode({
                location: pos
            }, (results, status) => {
                if (status === "OK" && results[0]) {
                    updateMap(pos.lat(), pos.lng(), results[0].formatted_address, false);
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
    
    // ✅ Re-init map after Livewire DOM updates
    document.addEventListener("livewire:navigated", function() {
        initAutocomplete();
    });


</script>