//map related variables
let map, marker, autocomplete, geocoder, streetView;
let lastLatLng = {
    lat: 14.5547,
    lng: 121.0244,
}; // Default Manila
let lastAddress = "";

function initMap() {
    const mapDiv = document.getElementById("map");
    const input = document.getElementById("address-input");

    if (!mapDiv || !input || typeof google === "undefined" || !google.maps) {
        console.log(
            "Map initialization failed - missing elements or Google Maps not loaded"
        );
        return;
    }

    // ✅ LOAD SAVED STATE
    lastLatLng = {
        lat: parseFloat(mapDiv.dataset.lat || 14.5547),
        lng: parseFloat(mapDiv.dataset.lng || 121.0244),
    };

    lastAddress = mapDiv.dataset.address || "";

    if (!map) {
        // Initialize only once
        map = new google.maps.Map(mapDiv, {
            center: lastLatLng,
            zoom: 14,
            streetViewControl: true,
            disableDefaultUI: false,
            styles: [
                /* your styles here */
            ],
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
            types: ["geocode"],
            componentRestrictions: {
                country: "ph",
            },
        });

        // === LISTENERS ===
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            const formatted = formatAddress(place.address_components || []);
            updateMap(
                place.geometry.location.lat(),
                place.geometry.location.lng(),
                formatted,
                true
            );
        });

        google.maps.event.addListener(marker, "dragend", (event) => {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();
            geocoder.geocode(
                {
                    location: {
                        lat,
                        lng,
                    },
                },
                (results, status) => {
                    if (status === "OK" && results[0]) {
                        const formatted = formatAddress(
                            results[0].address_components || []
                        );
                        updateMap(lat, lng, formatted, true);
                    }
                }
            );
        });

        streetView.addListener("position_changed", () => {
            const pos = streetView.getPosition();
            if (!pos) return;
            geocoder.geocode(
                {
                    location: pos,
                },
                (results, status) => {
                    if (status === "OK" && results[0]) {
                        const formatted = formatAddress(
                            results[0].address_components || []
                        );
                        updateMap(pos.lat(), pos.lng(), formatted, false);
                    }
                }
            );
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
    if (
        lastLatLng.lat === lat &&
        lastLatLng.lng === lng &&
        lastAddress === address
    )
        return;

    lastLatLng = { lat, lng };
    lastAddress = address;

    map.setCenter(lastLatLng);
    marker.setPosition(lastLatLng);

    if (address) {
        document.getElementById("address-input").value = address;
    }

    if (movePegman && streetView) {
        streetView.setPosition(lastLatLng);
    }

    Livewire.dispatch("setAddress", [address, lat, lng]);
}

function formatAddress(components) {
    let street = "";
    let city = "";
    let province = "";
    let country = "";

    components.forEach((comp) => {
        if (comp.types.includes("street_number")) street = comp.long_name;
        if (comp.types.includes("route")) street += " " + comp.long_name;
        if (comp.types.includes("locality")) city = comp.long_name;
        if (comp.types.includes("administrative_area_level_1"))
            province = comp.long_name;
        if (comp.types.includes("country")) country = comp.long_name;
    });

    if (!city) {
        const sublocality = components.find((comp) =>
            comp.types.includes("sublocality")
        );
        if (sublocality) city = sublocality.long_name;
    }

    return [street.trim(), city, province, country].filter(Boolean).join(", ");
}

function safeInitMap() {
    if (
        document.getElementById("map") &&
        typeof google !== "undefined" &&
        google.maps
    ) {
        initMap();
    } else {
        setTimeout(safeInitMap, 100);
    }
}

function locateUser() {
    if (!navigator.geolocation) return;

    navigator.geolocation.getCurrentPosition(({ coords }) => {
        geocoder.geocode(
            { location: { lat: coords.latitude, lng: coords.longitude } },
            (results, status) => {
                if (status === "OK" && results[0]) {
                    updateMap(
                        coords.latitude,
                        coords.longitude,
                        formatAddress(results[0].address_components || []),
                        true
                    );
                }
            }
        );
    });
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
