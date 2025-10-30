<div class="container-fluid py-3">
    <div class="row g-4">
        <!-- Sidebar Navigation -->
        <div class="col-12 col-md-3">
            @php
            $tabs = [
            'overview' => ['title' => 'Overview', 'desc' => 'Key details about this property.'],
            'images' => ['title' => 'Gallery', 'desc' => 'Browse property photos.'],
            'map' => ['title' => 'Location', 'desc' => 'View on the map and nearby areas.'],
            'host' => ['title' => 'Host', 'desc' => 'Contact information of the host.'],
            ];
            @endphp

            <div class="sticky-top " style="top: 90px;">
                @foreach($tabs as $tab => $info)
                @php
                $isActive = $active === $tab;
                $btnClass = 'btn text-start p-3 rounded-3 w-100 bg-transparent border-0';
                if ($isActive) {
                // active styling: light bg + left indicator + subtle shadow
                $btnClass .= ' active-tab';
                }
                @endphp

                <button type="button"
                    wire:click="setTab('{{ $tab }}')"
                    class="{{ $btnClass }} d-flex justify-content-start"
                    wire:loading.class="loading">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="fw-medium mb-1">{{ $info['title'] }}</div>
                            <small class="text-secondary d-none d-md-block">{{ $info['desc'] }}</small>
                        </div>

                        {{-- Spinner that shows only when this specific tab is loading --}}
                        <div wire:loading wire:target="setTab('{{ $tab }}')"
                            class="spinner-wrapper">
                            <span class="spinner-border spinner-border-sm"></span>
                        </div>
                    </div>
                </button>
                @endforeach
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-md-9">
            <div class="d-flex flex-column justify-content-start mb-3">
                <h5 class="mb-0 fw-semibold">{{ $property->name }}</h5>
                <small class="text-muted">{{ $property->address }} | {{ $property->type }}</small>
            </div>

            <div id="map-container" class="{{ $active === 'map' ? '' : 'd-none' }}">
                @php
                $lat = $property->latitude;
                $lng = $property->longitude;
                $destination = $property->name;
                @endphp
                <div class="row">
                    <div class="col-12 position-relative">

                        <!-- Map -->
                        <div wire:ignore id="map" class="rounded shadow-sm w-100" style="height: 400px;"></div>

                        <!-- Travel Mode Dropdown -->
                        <div class="position-absolute top-0 start-50 translate-middle-x w-75 px-2" style="z-index: 10; margin-top: 10px;">
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light-subtle border-0 px-3">
                                    <i class="bi bi-car-front-fill text-dark"></i>
                                </span>
                                <select id="mode" class="form-select border-0 bg-white text-dark fw-semibold shadow-none p-3" style="font-size: 13px;">
                                    <option value="DRIVING">Driving</option>
                                    <option value="WALKING">Walking</option>
                                    <option value="BICYCLING">Bicycling</option>
                                    <option value="TRANSIT">Transit</option>
                                </select>
                            </div>
                        </div>

                        

                        <!-- Route Info (distance + duration) -->
                        <div id="route-info"
                            class="position-absolute bottom-0 start-50 translate-middle-x bg-white shadow-sm rounded-3 px-3 py-2 text-center small fw-semibold text-secondary"
                            style="z-index: 10; margin-bottom: 10px; display: none;">
                            <i class="bi bi-clock me-1"></i>
                            <span id="duration">—</span> •
                            <i class="bi bi-signpost-2 me-1"></i>
                            <span id="distance">—</span>
                        </div>
                    </div>
                </div>
            </div>
            @if ($active === 'overview')
            <livewire:property-details.overview :propertyId="$propertyId" />
            @elseif ($active === 'images')
            <livewire:property-details.images :propertyId="$propertyId" />
            @elseif ($active === 'map')
            @livewire('property-details.mappings', [
            'lat' => $this->property->latitude,
            'lng' => $this->property->longitude,
            'destination' => $this->property->name
            ])
            @elseif ($active === 'host')
            <livewire:property-details.host :propertyId="$propertyId" />
            @endif
        </div>
    </div>

    <style>
        /* remove default focus flash but keep keyboard accessibility */
        button:focus {
            outline: none !important;
        }

        /* Active tab visual */
        .active-tab {
            background-color: #f8f9fa;
            /* subtle light background */
            position: relative;
        }

        /* left colored indicator */
        .active-tab::before {
            content: "";
            position: absolute;
            left: 0;
            top: 8px;
            bottom: 8px;
            width: 4px;
            background: #212529;
            /* Laravel dark color */
            border-radius: 2px;
        }

        /* Hover effect for non-active items */
        button:not(.active-tab):hover {
            background-color: ;
        }

        /* Keep the spinner aligned nicely */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* If your container has overflow clipping, show left indicator above */
        .col-md-3 {
            overflow: visible;
        }

        .loading {
            opacity: 0.7;
            cursor: wait;
        }

        .spinner-wrapper {
            position: absolute;
            right: 1rem;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 2px;
            color: #6c757d;
        }

        /* Make button position relative for absolute spinner positioning */
        .btn {
            position: relative;
        }
    </style>

    <script>
        let map, directionsService, directionsRenderer;

        function initMap() {
            const mapDiv = document.getElementById("map");
            if (!mapDiv) return;

            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                suppressMarkers: false,
                polylineOptions: {
                    strokeColor: "#0d6efd",
                    strokeWeight: 3
                }
            });

            map = new google.maps.Map(mapDiv, {
                zoom: 12,
                center: {
                    lat: 14.5995,
                    lng: 120.9842
                },
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false,
                streetViewControl: true,
                disableDefaultUI: false,
            });

            directionsRenderer.setMap(map);

            const destination = {
                lat: parseFloat(@json($lat)),
                lng: parseFloat(@json($lng))
            };

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        const userLocation = {
                            lat: pos.coords.latitude,
                            lng: pos.coords.longitude
                        };
                        drawRoute(userLocation, destination);
                    },
                    () => drawRoute({
                        lat: 14.5995,
                        lng: 120.9842
                    }, destination)
                );
            } else {
                drawRoute({
                    lat: 14.5995,
                    lng: 120.9842
                }, destination);
            }

            document.getElementById("mode").addEventListener("change", function() {
                const selectedMode = this.value;
                navigator.geolocation.getCurrentPosition((pos) => {
                    const userLocation = {
                        lat: pos.coords.latitude,
                        lng: pos.coords.longitude
                    };
                    drawRoute(userLocation, destination, selectedMode);
                });
            });

        }

        function drawRoute(origin, destination, mode = 'DRIVING') {
            const request = {
                origin: origin,
                destination: destination,
                travelMode: google.maps.TravelMode[mode],
            };

            directionsService.route(request, (result, status) => {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);

                    const route = result.routes[0].legs[0];

                    //  Display travel info
                    document.getElementById("route-info").style.display = "block";
                    document.getElementById("duration").textContent = route.duration.text;
                    document.getElementById("distance").textContent = route.distance.text;

                    // Modern 3D-style property marker
                    new google.maps.Marker({
                        position: destination,
                        map: map,
                        title: @json($destination),
                        icon: {
                            url: "https://upload.wikimedia.org/wikipedia/commons/8/88/Map_marker_icon_%E2%80%93_Nicolas_Mollet_%E2%80%93_Red.svg", // modern 3D pin
                            scaledSize: new google.maps.Size(40, 50), // adjust width & height
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(20, 50) // anchor at the bottom tip
                        }
                    });


                    setTimeout(() => google.maps.event.trigger(map, 'resize'), 300);
                } else {
                    console.error('Directions request failed:', status);
                    document.getElementById("route-info").style.display = "none";
                }
            });
        }

        function safeInitMap() {
            if (document.getElementById("map") && typeof google !== "undefined" && google.maps) {
                initMap();
            } else {
                setTimeout(safeInitMap, 300);
            }
        }

        document.addEventListener("livewire:navigated", safeInitMap);
        Livewire.hook("message.processed", safeInitMap);
    </script>

</div>