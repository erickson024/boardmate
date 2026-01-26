(function () {
    const propertyLocationPage = document.querySelector(".location-details"); // Check if we're on the location details page first
    if (!propertyLocationPage) return; // Exit early if not on this page
    let map,
        propertyMarker,
        userMarker,
        customMarker,
        geocoder,
        directionsService,
        directionsRenderer;
    let autocomplete, customStartingPointAutocomplete;
    let isSatellite = false;
    let mapInitialized = false;
    let propertyLocation;
    let currentUserLocation = null;
    let isUsingCustomStartingPoint = false;

    const mapStyles = [
        {
            featureType: "all",
            elementType: "geometry",
            stylers: [
                {
                    color: "#f5f5f5",
                },
            ],
        },
        {
            featureType: "water",
            elementType: "geometry",
            stylers: [
                {
                    color: "#c9e9f6",
                },
            ],
        },
        {
            featureType: "road",
            elementType: "geometry",
            stylers: [
                {
                    color: "#ffffff",
                },
            ],
        },
        {
            featureType: "poi",
            elementType: "labels",
            stylers: [
                {
                    visibility: "off",
                },
            ],
        },
    ];

    function initializeMap() {
        const mapDiv = document.getElementById("map");
        if (!mapDiv || !window.google || !window.google.maps) return;

        const propertyAddress = mapDiv.dataset.propertyAddress; // Get from data attribute
        const propertyName = mapDiv.dataset.propertyName; // Get from data attribute
        geocoder = new google.maps.Geocoder();

        geocoder.geocode(
            {
                address: propertyAddress,
            },
            function (results, status) {
                if (status !== "OK" || !results[0]) {
                    console.error("Geocoding error: " + status);
                    return;
                }

                propertyLocation = results[0].geometry.location;
                const initialCenter = {
                    lat: propertyLocation.lat(),
                    lng: propertyLocation.lng(),
                };

                if (!mapInitialized) {
                    map = new google.maps.Map(mapDiv, {
                        center: initialCenter,
                        zoom: 15,
                        styles: mapStyles,
                        disableDefaultUI: true,
                        streetViewControl: true,
                        zoomControl: false,
                        mapTypeControl: false,
                        fullscreenControl: false,
                        gestureHandling: "greedy",
                    });

                    propertyMarker = new google.maps.Marker({
                        map: map,
                        position: propertyLocation,
                        title: propertyName,
                        animation: google.maps.Animation.DROP,
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 12,
                            fillColor: "#dc3545",
                            fillOpacity: 1,
                            strokeColor: "#ffffff",
                            strokeWeight: 3,
                        },
                    });

                    directionsService = new google.maps.DirectionsService();
                    directionsRenderer = new google.maps.DirectionsRenderer({
                        map: map,
                        polylineOptions: {
                            strokeColor: "#1e40af",
                            strokeWeight: 4,
                        },
                        suppressMarkers: true,
                    });

                    setupCustomStartingPoint();
                    mapInitialized = true;
                }

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function (position) {
                            currentUserLocation = new google.maps.LatLng(
                                position.coords.latitude,
                                position.coords.longitude,
                            );

                            userMarker = new google.maps.Marker({
                                map: map,
                                position: currentUserLocation,
                                title: "Your Location",
                                icon: {
                                    path: google.maps.SymbolPath.CIRCLE,
                                    scale: 12,
                                    fillColor: "#1e40af",
                                    fillOpacity: 1,
                                    strokeColor: "#ffffff",
                                    strokeWeight: 3,
                                },
                            });

                            calculateAndShowRoute(currentUserLocation);
                        },
                        function () {
                            map.setCenter(initialCenter);
                            hideLoadingState();
                        },
                    );
                } else {
                    map.setCenter(initialCenter);
                    hideLoadingState();
                }
            },
        );
    }

    function calculateAndShowRoute(startLocation) {
        directionsService.route(
            {
                origin: startLocation,
                destination: propertyLocation,
                travelMode: "DRIVING",
            },
            function (result, status) {
                if (status === "OK") {
                    directionsRenderer.setDirections(result);
                    showUserRouteInfo(result);

                    const bounds = new google.maps.LatLngBounds();
                    bounds.extend(startLocation);
                    bounds.extend(propertyLocation);
                    map.fitBounds(bounds, 50);
                }
            },
        );
    }

    function setupCustomStartingPoint() {
        const changeBtn = document.getElementById("change-starting-point-btn");
        const panel = document.getElementById("custom-starting-point-panel");
        const closeBtn = document.getElementById("close-custom-panel");
        const input = document.getElementById("custom-starting-point-input");
        const applyBtn = document.getElementById("apply-custom-starting-point");
        const useCurrentBtn = document.getElementById(
            "use-current-location-btn",
        );
        const resetBtn = document.getElementById("reset-to-current-location");
        let selectedPlace = null;

        if (!input || !window.google || !window.google.maps) return;

        // Setup autocomplete
        customStartingPointAutocomplete = new google.maps.places.Autocomplete(
            input,
            {
                componentRestrictions: {
                    country: "ph",
                },
                types: ["geocode"],
            },
        );

        customStartingPointAutocomplete.addListener("place_changed", () => {
            const place = customStartingPointAutocomplete.getPlace();
            if (!place.geometry) {
                alert("Please select a valid address from the dropdown");
                return;
            }
            selectedPlace = place;
            applyBtn.disabled = false;
        });

        // Show/hide panel
        if (changeBtn) {
            changeBtn.addEventListener("click", () => {
                panel.style.display =
                    panel.style.display === "none" ? "block" : "none";
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener("click", () => {
                panel.style.display = "none";
            });
        }

        // Use current location button
        if (useCurrentBtn) {
            useCurrentBtn.addEventListener("click", () => {
                if (currentUserLocation) {
                    // Clear custom marker if exists
                    if (customMarker) customMarker.setMap(null);

                    // Recreate user marker if it was removed
                    if (!userMarker) {
                        userMarker = new google.maps.Marker({
                            map: map,
                            position: currentUserLocation,
                            title: "Your Location",
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 12,
                                fillColor: "#1e40af",
                                fillOpacity: 1,
                                strokeColor: "#ffffff",
                                strokeWeight: 3,
                            },
                        });
                    }

                    calculateAndShowRoute(currentUserLocation);
                    isUsingCustomStartingPoint = false;
                    resetBtn.style.display = "none";
                    panel.style.display = "none";
                    input.value = "";
                    selectedPlace = null;
                    applyBtn.disabled = true;
                } else {
                    alert(
                        "Unable to get your current location. Please allow location access.",
                    );
                }
            });
        }

        // Apply custom starting point
        if (applyBtn) {
            applyBtn.addEventListener("click", () => {
                if (!selectedPlace) return;

                const startLocation = selectedPlace.geometry.location;

                // Remove user marker and add custom marker
                if (userMarker) userMarker.setMap(null);
                if (customMarker) customMarker.setMap(null);

                customMarker = new google.maps.Marker({
                    map: map,
                    position: startLocation,
                    title: "Custom Starting Point",
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 12,
                        fillColor: "#15803d",
                        fillOpacity: 1,
                        strokeColor: "#ffffff",
                        strokeWeight: 3,
                    },
                });

                calculateAndShowRoute(startLocation);
                isUsingCustomStartingPoint = true;
                resetBtn.style.display = "block";
                panel.style.display = "none";
            });
        }

        // Reset to current location
        if (resetBtn) {
            resetBtn.addEventListener("click", () => {
                if (currentUserLocation) {
                    if (customMarker) customMarker.setMap(null);

                    userMarker = new google.maps.Marker({
                        map: map,
                        position: currentUserLocation,
                        title: "Your Location",
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 12,
                            fillColor: "#1e40af",
                            fillOpacity: 1,
                            strokeColor: "#ffffff",
                            strokeWeight: 3,
                        },
                    });

                    calculateAndShowRoute(currentUserLocation);
                    isUsingCustomStartingPoint = false;
                    resetBtn.style.display = "none";
                    input.value = "";
                    selectedPlace = null;
                    applyBtn.disabled = true;
                }
            });
        }
    }

    function showUserRouteInfo(result) {
        const route = result.routes[0];
        if (!route || !route.legs[0]) return;

        const leg = route.legs[0];
        const routeDistance = document.getElementById("user-route-distance");
        const routeDuration = document.getElementById("user-route-duration");
        const routeFrom = document.getElementById("user-route-from");

        // Update distance and duration
        if (routeDistance) routeDistance.textContent = leg.distance.text;
        if (routeDuration) routeDuration.textContent = leg.duration.text;

        // Update the starting location address
        if (routeFrom) {
            routeFrom.textContent = leg.start_address;
        }

        hideLoadingState();
    }

    function hideLoadingState() {
        const loadingState = document.getElementById("loading-state");
        if (loadingState) loadingState.style.display = "none";
    }

    if (window.googleMapsReady) {
        initializeMap();
    } else {
        document.addEventListener("google-maps-ready", initializeMap);
    }
})();
