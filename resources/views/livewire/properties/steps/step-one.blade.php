<div class="container overflow-auto" style="height:80%;">
    <div class="row">
        <div class="col-12">

            <input type="hidden" id="latitude" wire:model="latitude">
            <input type="hidden" id="longitude" wire:model="longitude">

            {{-- ✅ Map container --}}
            <div wire:ignore id="map" style="height: 250px; width: 100%;" class="shadow rounded"></div>


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
    //variables (global references)
    let map, marker, autocomplete, geocoder, streetView;

    //main initializer for your map, maker, autocomplete, geocoder, and streetview
    function initAutocomplete() {
        const input = document.getElementById("address-input");
        if (!input) return;

        // create a google places autocomplete linked to the input field
        autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['geocode'], //geographic addresses
            componentRestrictions: {
                country: "ph" //restricted to philippines
            }
        });

        //create the map centered in Manila
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: 14.5995,
                lng: 120.9842
            }, // Manila coordinates
            zoom: 6,
            streetViewControl: true, //enable the streetview pegman
        });

        // places a dragable marker on the map
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

            updateMap( //Updates the map + marker + address field
                place.geometry.location.lat(),
                place.geometry.location.lng(),
                place.formatted_address,
                true
            );
        });

        // --- Marker Drag Listener---
        google.maps.event.addListener(marker, "dragend", (event) => { //Gets new coordinates.
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();

            geocoder.geocode({ //Reverse geocodes them → fetches the corresponding address.
                location: {
                    lat,
                    lng
                }
            }, (results, status) => {
                if (status === "OK" && results[0]) {
                    updateMap(lat, lng, results[0].formatted_address, true); //Updates everything via updateMap().
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


    document.addEventListener('DOMContentLoaded', () => {
        console.log("DOM");
        initAutocomplete();
    });


    // ✅ Re-init map after Livewire DOM updates
    document.addEventListener('livewire:navigated', () => {
        console.log("Navigated");
        initAutocomplete();
    });
</script>