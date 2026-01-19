<div>
    {{-- Map Container --}}
    <div class="position-relative map-container" id="map-container" style="border-radius: 0; overflow: hidden; box-shadow: none; flex: 1; width: 100%; margin-top: 8%;">

        {{-- Loading state --}}
        <div wire:ignore id="map" style="height: 100%; width: 100%;"></div>

        {{-- Map controls overlay --}}
        <div class="position-absolute top-0 end-0 m-3 d-flex flex-column gap-3" style="z-index: 5;">
            <button
                id="recenter-btn"
                class="btn btn-light rounded-circle shadow-lg"
                style="width: 50px; height: 50px; transition: all 0.3s ease; border: none; font-size: 18px;"
                title="Recenter map">
                <i class="bi bi-crosshair"></i>
            </button>
            <button
                id="satellite-toggle"
                class="btn btn-light rounded-circle shadow-lg"
                style="width: 50px; height: 50px; transition: all 0.3s ease; border: none; font-size: 18px;"
                title="Toggle satellite view">
                <i class="bi bi-globe"></i>
            </button>
            <button
                id="custom-route-btn"
                class="btn rounded-circle shadow-lg"
                style="width: 50px; height: 50px; transition: all 0.3s ease; border: none; font-size: 18px; background: linear-gradient(135deg, #007bff, #0056b3); color: white;"
                title="Add custom route">
                <i class="bi bi-geo"></i>
            </button>
        </div>
        <style>
            #recenter-btn:hover,
            #satellite-toggle:hover {
                transform: scale(1.1);
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2) !important;
            }

            #custom-route-btn:hover {
                transform: scale(1.1);
                box-shadow: 0 8px 16px rgba(0, 91, 187, 0.4) !important;
            }
        </style>
    </div>
</div>


<script>
    (function() {
        let map, propertyMarker, userMarker, customMarker, geocoder, directionsService, directionsRenderer;
        let autocomplete, customDirectionsRenderer;
        let isSatellite = false;
        let mapInitialized = false;
        let propertyLocation;

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

        function initializeMap() {
            const mapDiv = document.getElementById('map');
            if (!mapDiv || !window.google || !window.google.maps) return;

            const propertyAddress = "{{ $property->address }}";
            geocoder = new google.maps.Geocoder();

            geocoder.geocode({
                address: propertyAddress
            }, function(results, status) {
                if (status !== 'OK' || !results[0]) {
                    console.error('Geocoding error: ' + status);
                    return;
                }

                propertyLocation = results[0].geometry.location;
                const initialCenter = {
                    lat: propertyLocation.lat(),
                    lng: propertyLocation.lng()
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
                        gestureHandling: 'greedy'
                    });

                    propertyMarker = new google.maps.Marker({
                        map: map,
                        position: propertyLocation,
                        title: "{{ $property->propertyName }}",
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

                    directionsService = new google.maps.DirectionsService();
                    directionsRenderer = new google.maps.DirectionsRenderer({
                        map: map,
                        polylineOptions: {
                            strokeColor: '#1e40af',
                            strokeWeight: 4
                        },
                        suppressMarkers: true
                    });

                    customDirectionsRenderer = new google.maps.DirectionsRenderer({
                        map: map,
                        polylineOptions: {
                            strokeColor: '#15803d',
                            strokeWeight: 4,
                            strokeOpacity: 0.8
                        },
                        suppressMarkers: true
                    });

                    setupCustomControls(initialCenter);
                    setupCustomRoute();
                    mapInitialized = true;
                }

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const userLocation = new google.maps.LatLng(
                            position.coords.latitude,
                            position.coords.longitude
                        );

                        userMarker = new google.maps.Marker({
                            map: map,
                            position: userLocation,
                            title: 'Your Location',
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 12,
                                fillColor: "#1e40af",
                                fillOpacity: 1,
                                strokeColor: "#ffffff",
                                strokeWeight: 3
                            }
                        });

                        directionsService.route({
                            origin: userLocation,
                            destination: propertyLocation,
                            travelMode: 'DRIVING'
                        }, function(result, status) {
                            if (status === 'OK') {
                                directionsRenderer.setDirections(result);
                                showUserRouteInfo(result);

                                const bounds = new google.maps.LatLngBounds();
                                bounds.extend(userLocation);
                                bounds.extend(propertyLocation);
                                map.fitBounds(bounds, 50);
                            }
                        });
                    }, function() {
                        map.setCenter(initialCenter);
                        hideLoadingState();
                    });
                } else {
                    map.setCenter(initialCenter);
                    hideLoadingState();
                }
            });
        }

        function setupCustomControls(center) {
            const recenterBtn = document.getElementById('recenter-btn');
            const satelliteBtn = document.getElementById('satellite-toggle');
            const customRouteBtn = document.getElementById('custom-route-btn');

            if (recenterBtn) {
                recenterBtn.addEventListener('click', () => {
                    map.setCenter(center);
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

            if (customRouteBtn) {
                customRouteBtn.addEventListener('click', () => {
                    const panel = document.getElementById('custom-route-panel');
                    panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
                });
            }
        }

        function setupCustomRoute() {
            const input = document.getElementById('custom-address-input');
            const panel = document.getElementById('custom-route-panel');
            const closeBtn = document.getElementById('close-route-panel');
            const submitBtn = document.getElementById('route-submit-btn');
            const clearBtn = document.getElementById('clear-route-btn');
            let selectedPlace = null;

            if (!input || !window.google || !window.google.maps) return;

            autocomplete = new google.maps.places.Autocomplete(input, {
                componentRestrictions: {
                    country: 'ph'
                },
                types: ['geocode'],
            });

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();
                if (!place.geometry) {
                    alert('Please select a valid address from the dropdown');
                    return;
                }
                selectedPlace = place;
                submitBtn.disabled = false;
            });

            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    panel.style.display = 'none';
                });
            }

            if (submitBtn) {
                submitBtn.addEventListener('click', () => {
                    if (!selectedPlace) return;

                    const startLocation = selectedPlace.geometry.location;
                    clearBtn.style.display = 'block';

                    directionsService.route({
                        origin: startLocation,
                        destination: propertyLocation,
                        travelMode: 'DRIVING'
                    }, function(result, status) {
                        if (status === 'OK') {
                            customDirectionsRenderer.setDirections(result);
                            showCustomRouteInfo(result);

                            if (customMarker) customMarker.setMap(null);
                            customMarker = new google.maps.Marker({
                                map: map,
                                position: startLocation,
                                title: 'Starting Point',
                                icon: {
                                    path: google.maps.SymbolPath.CIRCLE,
                                    scale: 12,
                                    fillColor: "#15803d",
                                    fillOpacity: 1,
                                    strokeColor: "#ffffff",
                                    strokeWeight: 3
                                }
                            });

                            const bounds = new google.maps.LatLngBounds();
                            bounds.extend(startLocation);
                            bounds.extend(propertyLocation);
                            map.fitBounds(bounds, 50);
                        }
                    });
                });
            }

            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    customDirectionsRenderer.setDirections({
                        routes: []
                    });
                    if (customMarker) customMarker.setMap(null);
                    input.value = '';
                    selectedPlace = null;
                    submitBtn.disabled = true;
                    clearBtn.style.display = 'none';
                    hideCustomRouteInfo();
                });
            }
        }

        function showUserRouteInfo(result) {
            const route = result.routes[0];
            if (!route || !route.legs[0]) return;

            const leg = route.legs[0];
            const routeInfo = document.getElementById('user-route-info');
            const routeDistance = document.getElementById('user-route-distance');
            const routeDuration = document.getElementById('user-route-duration');

            if (routeDistance) routeDistance.textContent = leg.distance.text;
            if (routeDuration) routeDuration.textContent = leg.duration.text;
            if (routeInfo) routeInfo.style.display = 'block';

            hideLoadingState();
        }

        function showCustomRouteInfo(result) {
            const route = result.routes[0];
            if (!route || !route.legs[0]) return;

            const leg = route.legs[0];
            const routeInfo = document.getElementById('custom-route-info');
            const routeDistance = document.getElementById('custom-route-distance');
            const routeDuration = document.getElementById('custom-route-duration');

            if (routeDistance) routeDistance.textContent = leg.distance.text;
            if (routeDuration) routeDuration.textContent = leg.duration.text;
            if (routeInfo) routeInfo.style.display = 'block';
        }

        function hideCustomRouteInfo() {
            const routeInfo = document.getElementById('custom-route-info');
            if (routeInfo) routeInfo.style.display = 'none';
        }

        function hideLoadingState() {
            const loadingState = document.getElementById('loading-state');
            if (loadingState) loadingState.style.display = 'none';
        }

        if (window.googleMapsReady) {
            initializeMap();
        } else {
            document.addEventListener('google-maps-ready', initializeMap);
        }
    })();
</script>