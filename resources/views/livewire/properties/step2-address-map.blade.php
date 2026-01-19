<div class="row step2-address-map">

   <div class="col-12 mb-2">
      <p class="fs-6 fw-semibold text-start mb-1">Property Location <span class="text-danger">*</span></p>
      <small class="text-muted">Enter the full address so tenants can locate it easily. You can drag the marker or use Street View for precise positioning.</small>
   </div>


   <div class="col-12 mb-3" wire:ignore>
      <div class="position-relative">
         <!-- input field -->
         <x-floating-labels.input
            type="text"
            class="form-control pe-5"
            id="address-input"
            placeholder="Search for an address"
            autocomplete="off"
            label="Search the property address" />

         <div class="position-absolute top-50 end-0 translate-middle-y me-3" id="address-status">
            <!-- Status indicator will appear here -->
         </div>
      </div>

      <!-- Helper text with dynamic state -->
      <div id="address-helper" class="mt-2 small" style="display: none;">
         <i class="bi bi-exclamation-circle me-1"></i>
         <span id="helper-text">Please enter and select an address from the dropdown</span>
      </div>
   </div>

   <!-- MAP with enhanced styling -->
   <div class="col-12" wire:ignore>
      <div class="position-relative map-container" id="map-container" style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
         <div id="map" style="height: 250px; width: 100%;"></div>

         <!-- Empty state overlay -->
         <div id="empty-state" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(248, 249, 250, 0.95); pointer-events: none;">
            <div class="text-center px-4">
               <i class="bi bi-geo-alt fs-1 text-muted mb-3 d-block"></i>
               <p class="fw-semibold text-muted mb-1">No Location Selected</p>
               <small class="text-muted">Search for an address above to begin</small>
            </div>
         </div>

         <!-- Floating info card -->
         <div id="location-info" class="position-absolute top-0 start-0 m-3 bg-white rounded-3 shadow-sm p-3" style="max-width: 280px; display: none;">
            <div class="d-flex align-items-start">
               <i class="bi bi-geo-alt-fill text-danger fs-4 me-2"></i>
               <div class="flex-grow-1">
                  <p class="mb-1 fw-semibold small">Selected Location</p>
                  <p class="mb-0 small text-muted" id="selected-address">No location selected</p>
               </div>
            </div>
         </div>

         <!-- Success badge -->
         <div id="location-success" class="position-absolute top-0 start-0 m-3 bg-success text-white rounded-3 shadow-sm px-3 py-2" style="display: none;">
            <i class="bi bi-check-circle-fill me-2"></i>
            <small class="fw-semibold">Location Verified</small>
         </div>

         <!-- Map controls overlay -->
         <div class="position-absolute top-0 end-0 m-3 d-flex flex-column gap-2">
            <button
               id="recenter-btn"
               class="btn btn-light rounded-circle shadow-sm"
               style="width: 44px; height: 44px;"
               title="Recenter map">
               <i class="bi bi-crosshair"></i>
            </button>
            <button
               id="satellite-toggle"
               class="btn btn-light rounded-circle shadow-sm"
               style="width: 44px; height: 44px;"
               title="Toggle satellite view">
               <i class="bi bi-globe"></i>
            </button>
         </div>

         <!-- Coordinates display -->
         <div class="position-absolute bottom-0 start-0 m-3 bg-white rounded-2 shadow-sm px-3 py-2" style="font-size: 11px; display: none;" id="coords-display">
            <span class="text-muted">Lat:</span> <span id="lat-display" class="fw-semibold">—</span>
            <span class="text-muted ms-2">Lng:</span> <span id="lng-display" class="fw-semibold">—</span>
         </div>
      </div>
   </div>

   <div class="col-12">
      <!-- Validation errors from Livewire -->
      @error('address')
      <div class="alert alert-danger d-flex align-items-center py-2 mt-2">
         <i class="bi bi-exclamation-circle me-2"></i>
         <small>{{ $message }}</small>
      </div>
      @enderror
   </div>




   <!-- hidden fields for Livewire binding -->
   <input type="hidden" wire:model="address">
   <input type="hidden" wire:model="latitude">
   <input type="hidden" wire:model="longitude">

   <style>

   </style>
</div>

<script>
   (function() {
      let map, marker, autocomplete, geocoder, streetView;
      let lastLatLng = {
         lat: 14.5547,
         lng: 121.0244
      };
      let mapInitialized = false;
      let autocompleteInitialized = false;
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

         if (!mapDiv || !input) return;
         if (!window.google || !window.google.maps) return;

         if (!mapInitialized) {
            map = new google.maps.Map(mapDiv, {
               center: lastLatLng,
               zoom: 13,
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

            marker.addListener('dragstart', () => {
               hideLocationInfo();
            });

            marker.addListener('dragend', e => {
               reverseGeocode(e.latLng);
            });

            streetView.addListener('position_changed', () => {
               const pos = streetView.getPosition();
               if (pos) reverseGeocode(pos);
            });

            setupCustomControls();
            mapInitialized = true;
            updateCoordinatesDisplay(lastLatLng.lat, lastLatLng.lng);

            // Load saved data from Livewire component
            loadSavedLocation();
         } else {
            google.maps.event.trigger(map, 'resize');
            map.setCenter(lastLatLng);
         }

         initAutocomplete(input);
      }

      function loadSavedLocation() {
         // Get saved values from hidden inputs
         const addressInput = document.querySelector('input[wire\\:model="address"]');
         const latInput = document.querySelector('input[wire\\:model="latitude"]');
         const lngInput = document.querySelector('input[wire\\:model="longitude"]');

         if (addressInput && latInput && lngInput) {
            const savedAddress = addressInput.value;
            const savedLat = parseFloat(latInput.value);
            const savedLng = parseFloat(lngInput.value);

            // If we have saved data, restore it
            if (savedAddress && !isNaN(savedLat) && !isNaN(savedLng)) {
               console.log('Restoring saved location:', savedAddress);

               // Update map without dispatching to Livewire (data already there)
               lastLatLng = {
                  lat: savedLat,
                  lng: savedLng
               };
               hasValidLocation = true;

               if (map) {
                  map.setCenter(lastLatLng);
                  marker.setPosition(lastLatLng);
               }

               const input = document.getElementById('address-input');
               if (input) {
                  input.value = savedAddress;
                  input.classList.add('has-value');
               }

               updateCoordinatesDisplay(savedLat, savedLng);
               hideEmptyState();

               // Show map has location
               const mapContainer = document.getElementById('map-container');
               if (mapContainer) {
                  mapContainer.classList.add('has-location');
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

         autocompleteInitialized = true;
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
         if (input) {
            input.value = address;
            input.classList.add('has-value');
            input.classList.remove('validation-required');
         }

         if (movePegman && streetView) {
            streetView.setPosition(lastLatLng);
         }

         updateCoordinatesDisplay(lat, lng);
         showValidationState('success', 'Location verified successfully');
         hideEmptyState();
         showLocationSuccess();

         if (window.Livewire) {
            Livewire.dispatch('setAddress', {
               address: address,
               lat: lat,
               lng: lng
            });
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
         const coordsDisplay = document.getElementById('coords-display');
         const latDisplay = document.getElementById('lat-display');
         const lngDisplay = document.getElementById('lng-display');

         if (coordsDisplay) coordsDisplay.style.display = 'block';
         if (latDisplay) latDisplay.textContent = lat.toFixed(6);
         if (lngDisplay) lngDisplay.textContent = lng.toFixed(6);
      }

      function showValidationState(type, message) {
         const helper = document.getElementById('address-helper');
         const helperText = document.getElementById('helper-text');
         const mapContainer = document.getElementById('map-container');
         const statusEl = document.getElementById('address-status');

         if (!helper || !helperText) return;

         helper.style.display = 'block';
         helperText.textContent = message;

         // Reset classes
         helper.className = 'mt-2 small';
         mapContainer.classList.remove('has-location', 'validation-error');

         if (type === 'success') {
            helper.classList.add('text-success');
            mapContainer.classList.add('has-location');
            if (statusEl) statusEl.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
            setTimeout(() => {
               helper.style.display = 'none';
               if (statusEl) statusEl.innerHTML = '';
            }, 3000);
         } else if (type === 'error') {
            helper.classList.add('text-danger');
            mapContainer.classList.add('validation-error');
            if (statusEl) statusEl.innerHTML = '<i class="bi bi-x-circle-fill text-danger"></i>';
            setTimeout(() => {
               if (statusEl) statusEl.innerHTML = '';
            }, 3000);
         } else {
            helper.classList.add('text-muted');
         }
      }

      function hideEmptyState() {
         const emptyState = document.getElementById('empty-state');
         if (emptyState) {
            emptyState.classList.add('fade-out');
            setTimeout(() => {
               emptyState.style.display = 'none';
            }, 300);
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

      function showLocationInfo(address) {
         const infoCard = document.getElementById('location-info');
         const addressEl = document.getElementById('selected-address');
         if (infoCard && addressEl) {
            addressEl.textContent = address;
            infoCard.style.display = 'block';
            setTimeout(() => {
               infoCard.style.opacity = '0';
               infoCard.style.transition = 'opacity 0.3s';
               setTimeout(() => {
                  infoCard.style.display = 'none';
                  infoCard.style.opacity = '1';
               }, 300);
            }, 4000);
         }
      }

      function hideLocationInfo() {
         const infoCard = document.getElementById('location-info');
         if (infoCard) infoCard.style.display = 'none';
      }

      // Show validation prompt when input is focused but empty
      const input = document.getElementById('address-input');
      if (input) {
         input.addEventListener('focus', () => {
            if (!hasValidLocation && !input.value) {
               showValidationState('info', 'Start typing to search for an address');
            }
         });

         // Detect when input is cleared
         input.addEventListener('input', (e) => {
            if (e.target.value === '' || e.target.value.trim() === '') {
               clearLocation();
            }
         });

         // Also detect backspace/delete on empty field
         input.addEventListener('keydown', (e) => {
            if ((e.key === 'Backspace' || e.key === 'Delete') && e.target.value === '') {
               clearLocation();
            }
         });
      }

      function clearLocation() {
         console.log('Clearing location data');

         hasValidLocation = false;

         // Reset to default position
         lastLatLng = {
            lat: 14.5547,
            lng: 121.0244
         };

         // Update map
         if (map && marker) {
            map.setCenter(lastLatLng);
            map.setZoom(13);
            marker.setPosition(lastLatLng);
         }

         // Clear input styling
         const input = document.getElementById('address-input');
         if (input) {
            input.classList.remove('has-value');
            input.classList.remove('validation-required');
         }

         // Show empty state
         const emptyState = document.getElementById('empty-state');
         if (emptyState) {
            emptyState.classList.remove('fade-out');
            emptyState.style.display = 'flex';
         }

         // Hide coordinates
         const coordsDisplay = document.getElementById('coords-display');
         if (coordsDisplay) {
            coordsDisplay.style.display = 'none';
         }

         // Remove map styling
         const mapContainer = document.getElementById('map-container');
         if (mapContainer) {
            mapContainer.classList.remove('has-location');
            mapContainer.classList.remove('validation-error');
         }

         // Hide helper text
         const helper = document.getElementById('address-helper');
         if (helper) {
            helper.style.display = 'none';
         }

         // Clear Livewire data
         if (window.Livewire) {
            Livewire.dispatch('setAddress', {
               address: '',
               lat: '',
               lng: ''
            });
         }
      }

      function tryInitMap() {
         if (window.google && window.google.maps) {
            setTimeout(initMap, 100);
         }
      }

      document.addEventListener('livewire:initialized', tryInitMap);
      document.addEventListener('google-maps-ready', tryInitMap);

      document.addEventListener('livewire:init', () => {
         Livewire.on('stepChanged', step => {
            if (step === 2) {
               setTimeout(() => {
                  if (map) {
                     google.maps.event.trigger(map, 'resize');
                     map.setCenter(lastLatLng);
                  }
                  const input = document.getElementById('address-input');
                  if (input && !autocompleteInitialized) {
                     initAutocomplete(input);
                  }
               }, 300);
            }
         });
      });

      document.addEventListener('livewire:navigating', () => {
         mapInitialized = false;
         autocompleteInitialized = false;
         hasValidLocation = false;
         if (autocomplete) {
            google.maps.event.clearInstanceListeners(autocomplete);
         }
         map = null;
         marker = null;
         autocomplete = null;
         geocoder = null;
         streetView = null;
      });

      if (document.readyState === 'loading') {
         document.addEventListener('DOMContentLoaded', tryInitMap);
      } else {
         tryInitMap();
      }
   })();
</script>