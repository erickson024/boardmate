<div class="row step2-address-map">

   <div class="col-12 mb-2">
      <p class="fs-6 fw-semibold text-start mb-1">Property Location <span class="text-danger">*</span></p>
      <small class="text-muted">Enter the full address so tenants can locate it easily. You can drag the marker or use Street View for precise positioning.</small>
   </div>

   <div class="col-12 mb-3" wire:ignore>
      <div class="position-relative">
         <!-- Visible input field -->
         <x-floating-labels.input
            type="text"
            class="form-control pe-5"
            id="address-input"
            placeholder="Search for an address"
            autocomplete="off"
            label="Search the property address"
            required />

         <div class="position-absolute top-50 end-0 translate-middle-y me-3" id="address-status">
            <!-- Status indicator will appear here -->
         </div>
      </div>

      <!-- Helper text with dynamic state -->
      <div id="address-helper" class="mt-2 small" style="display: none;">
         <i class="bi bi-exclamation-circle me-1"></i>
         <span id="helper-text">Please enter and select an address from the dropdown</span>
      </div>

      <!-- Validation warning for empty field -->
      <div id="address-required-warning" class="mt-2 small text-danger" style="display: none;">
         <i class="bi bi-exclamation-triangle-fill me-1"></i>
         <span>Property location is required. Please search and select an address.</span>
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

         <!-- Success badge -->
         <div id="location-success" class="position-absolute top-0 start-0 m-3 bg-success text-white rounded-3 shadow-sm px-3 py-2" style="display: none;">
            <i class="bi bi-check-circle-fill me-2"></i>
            <small class="fw-semibold">Location Verified</small>
         </div>

         <!-- Map controls overlay -->
         <div class="position-absolute top-0 end-0 m-3 d-flex flex-column gap-2">
            <button
               id="recenter-btn"
               type="button"
               class="btn btn-light rounded-circle shadow-sm"
               style="width: 44px; height: 44px;"
               title="Recenter map">
               <i class="bi bi-crosshair"></i>
            </button>
            <button
               id="satellite-toggle"
               type="button"
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

   <!-- Hidden fields for Livewire binding -->
   <input type="hidden" wire:model="address" id="hidden-address">
   <input type="hidden" wire:model="latitude" id="hidden-latitude">
   <input type="hidden" wire:model="longitude" id="hidden-longitude">
</div>

<script>
   (function(){
      ("use strict");

      // State management
      const state = {
         map: null,
         marker: null,
         autocomplete: null,
         geocoder: null,
         streetView: null,
         lastLatLng: {
            lat: 14.5547,
            lng: 121.0244
         },
         mapInitialized: false,
         autocompleteInitialized: false,
         isSatellite: false,
         hasValidLocation: false,
         userInteracted: false, // Track if user has interacted with the field
      };

      // Constants
      const SELECTORS = {
         map: "#map",
         input: "#address-input",
         addressStatus: "#address-status",
         addressHelper: "#address-helper",
         helperText: "#helper-text",
         requiredWarning: "#address-required-warning",
         emptyState: "#empty-state",
         locationSuccess: "#location-success",
         recenterBtn: "#recenter-btn",
         satelliteToggle: "#satellite-toggle",
         coordsDisplay: "#coords-display",
         latDisplay: "#lat-display",
         lngDisplay: "#lng-display",
         mapContainer: "#map-container",
         hiddenAddress: "#hidden-address",
         hiddenLat: "#hidden-latitude",
         hiddenLng: "#hidden-longitude",
      };

      const MAP_STYLES = [{
            featureType: "all",
            elementType: "geometry",
            stylers: [{
               color: "#f5f5f5"
            }],
         },
         {
            featureType: "water",
            elementType: "geometry",
            stylers: [{
               color: "#c9e9f6"
            }],
         },
         {
            featureType: "road",
            elementType: "geometry",
            stylers: [{
               color: "#ffffff"
            }],
         },
         {
            featureType: "poi",
            elementType: "labels",
            stylers: [{
               visibility: "off"
            }],
         },
      ];

      const DEFAULT_POSITION = {
         lat: 14.5547,
         lng: 121.0244
      };

      // Utility functions
      const $ = (selector) => document.querySelector(selector);

      function initMap() {
         const mapDiv = $(SELECTORS.map);
         const input = $(SELECTORS.input);

         if (!mapDiv || !input || !window.google?.maps) return;

         if (!state.mapInitialized) {
            createMap(mapDiv);
            createMarker();
            setupMapListeners();
            setupCustomControls();
            state.mapInitialized = true;
            updateCoordinatesDisplay(
               state.lastLatLng.lat,
               state.lastLatLng.lng,
            );
            loadSavedLocation();
         } else {
            google.maps.event.trigger(state.map, "resize");
            state.map.setCenter(state.lastLatLng);
         }

         initAutocomplete(input);
      }

      function createMap(mapDiv) {
         state.map = new google.maps.Map(mapDiv, {
            center: state.lastLatLng,
            zoom: 13,
            styles: MAP_STYLES,
            disableDefaultUI: true,
            streetViewControl: true,
            gestureHandling: "greedy",
         });

         state.geocoder = new google.maps.Geocoder();
         state.streetView = state.map.getStreetView();
      }

      function createMarker() {
         state.marker = new google.maps.Marker({
            map: state.map,
            position: state.lastLatLng,
            draggable: true,
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
      }

      function setupMapListeners() {
         state.marker.addListener("dragend", (e) => {
            state.userInteracted = true;
            reverseGeocode(e.latLng);
         });

         state.streetView.addListener("position_changed", () => {
            const pos = state.streetView.getPosition();
            if (pos) {
               state.userInteracted = true;
               reverseGeocode(pos);
            }
         });
      }

      function loadSavedLocation() {
         const addressInput = $(SELECTORS.hiddenAddress);
         const latInput = $(SELECTORS.hiddenLat);
         const lngInput = $(SELECTORS.hiddenLng);

         if (!addressInput || !latInput || !lngInput) return;

         const savedAddress = addressInput.value;
         const savedLat = parseFloat(latInput.value);
         const savedLng = parseFloat(lngInput.value);

         if (savedAddress && !isNaN(savedLat) && !isNaN(savedLng)) {
            state.lastLatLng = {
               lat: savedLat,
               lng: savedLng
            };
            state.hasValidLocation = true;

            if (state.map && state.marker) {
               state.map.setCenter(state.lastLatLng);
               state.marker.setPosition(state.lastLatLng);
            }

            const input = $(SELECTORS.input);
            if (input) {
               input.value = savedAddress;
               input.classList.add("has-value");
            }

            updateCoordinatesDisplay(savedLat, savedLng);
            hideEmptyState();
            $(SELECTORS.mapContainer)?.classList.add("has-location");
            hideRequiredWarning();
         }
      }

      function setupCustomControls() {
         const recenterBtn = $(SELECTORS.recenterBtn);
         const satelliteBtn = $(SELECTORS.satelliteToggle);

         recenterBtn?.addEventListener("click", () => {
            state.map.setCenter(state.lastLatLng);
            state.map.setZoom(15);
         });

         satelliteBtn?.addEventListener("click", () => {
            state.isSatellite = !state.isSatellite;
            state.map.setMapTypeId(state.isSatellite ? "satellite" : "roadmap");
            const icon = satelliteBtn.querySelector("i");
            if (icon)
               icon.className = state.isSatellite ?
               "bi bi-map" :
               "bi bi-globe";
         });
      }

      function initAutocomplete(input) {
         if (!input || !window.google?.maps) return;

         if (state.autocomplete) {
            google.maps.event.clearInstanceListeners(state.autocomplete);
         }

         state.autocomplete = new google.maps.places.Autocomplete(input, {
            componentRestrictions: {
               country: "ph"
            },
            types: ["geocode"],
         });

         state.autocomplete.addListener("place_changed", () => {
            const place = state.autocomplete.getPlace();

            if (!place.geometry) {
               showValidationState(
                  "error",
                  "Please select a valid address from the dropdown",
               );
               return;
            }

            state.userInteracted = true;
            updateMap(
               place.geometry.location.lat(),
               place.geometry.location.lng(),
               formatAddress(place.address_components),
               true,
            );
         });

         state.autocompleteInitialized = true;
      }

      function reverseGeocode(latLng) {
         if (!state.geocoder) return;

         state.geocoder.geocode({
            location: latLng
         }, (results, status) => {
            if (status === "OK" && results[0]) {
               updateMap(
                  latLng.lat(),
                  latLng.lng(),
                  formatAddress(results[0].address_components),
                  false,
               );
            }
         });
      }

      function updateMap(lat, lng, address, movePegman) {
         state.lastLatLng = {
            lat,
            lng
         };
         state.hasValidLocation = true;

         if (state.map && state.marker) {
            state.map.panTo(state.lastLatLng);
            state.marker.setPosition(state.lastLatLng);
            state.marker.setAnimation(google.maps.Animation.BOUNCE);
            setTimeout(() => state.marker.setAnimation(null), 1500);
         }

         const input = $(SELECTORS.input);
         if (input) {
            input.value = address;
            input.classList.add("has-value");
            input.classList.remove("is-invalid");
         }

         if (movePegman && state.streetView) {
            state.streetView.setPosition(state.lastLatLng);
         }

         updateCoordinatesDisplay(lat, lng);
         showValidationState("success", "Location verified successfully");
         hideEmptyState();
         showLocationSuccess();
         hideRequiredWarning();

         window.Livewire?.dispatch("setAddress", {
            address,
            lat,
            lng
         });
      }

      function formatAddress(components = []) {
         const parts = {
            street: "",
            city: "",
            province: "",
            country: ""
         };

         components.forEach((c) => {
            if (c.types.includes("street_number")) parts.street = c.long_name;
            if (c.types.includes("route")) parts.street += " " + c.long_name;
            if (c.types.includes("locality")) parts.city = c.long_name;
            if (c.types.includes("administrative_area_level_1"))
               parts.province = c.long_name;
            if (c.types.includes("country")) parts.country = c.long_name;
         });

         return [parts.street.trim(), parts.city, parts.province, parts.country]
            .filter(Boolean)
            .join(", ");
      }

      function updateCoordinatesDisplay(lat, lng) {
         const coordsDisplay = $(SELECTORS.coordsDisplay);
         const latDisplay = $(SELECTORS.latDisplay);
         const lngDisplay = $(SELECTORS.lngDisplay);

         if (coordsDisplay) coordsDisplay.style.display = "block";
         if (latDisplay) latDisplay.textContent = lat.toFixed(6);
         if (lngDisplay) lngDisplay.textContent = lng.toFixed(6);
      }

      function showValidationState(type, message) {
         const helper = $(SELECTORS.addressHelper);
         const helperText = $(SELECTORS.helperText);
         const mapContainer = $(SELECTORS.mapContainer);
         const statusEl = $(SELECTORS.addressStatus);

         if (!helper || !helperText) return;

         helper.style.display = "block";
         helperText.textContent = message;
         helper.className = "mt-2 small";
         mapContainer?.classList.remove("has-location", "validation-error");

         const actions = {
            success: () => {
               helper.classList.add("text-success");
               mapContainer?.classList.add("has-location");
               if (statusEl)
                  statusEl.innerHTML =
                  '<i class="bi bi-check-circle-fill text-success"></i>';
               setTimeout(() => {
                  helper.style.display = "none";
                  if (statusEl) statusEl.innerHTML = "";
               }, 3000);
            },
            error: () => {
               helper.classList.add("text-danger");
               mapContainer?.classList.add("validation-error");
               if (statusEl)
                  statusEl.innerHTML =
                  '<i class="bi bi-x-circle-fill text-danger"></i>';
               setTimeout(() => {
                  if (statusEl) statusEl.innerHTML = "";
               }, 3000);
            },
            info: () => {
               helper.classList.add("text-muted");
            },
         };

         actions[type]?.();
      }

      function showRequiredWarning() {
         const warning = $(SELECTORS.requiredWarning);
         const input = $(SELECTORS.input);
         const mapContainer = $(SELECTORS.mapContainer);

         if (warning) warning.style.display = "block";
         if (input) input.classList.add("is-invalid");
         if (mapContainer) mapContainer.classList.add("validation-error");
      }

      function hideRequiredWarning() {
         const warning = $(SELECTORS.requiredWarning);
         const input = $(SELECTORS.input);
         const mapContainer = $(SELECTORS.mapContainer);

         if (warning) warning.style.display = "none";
         if (input) input.classList.remove("is-invalid");
         if (mapContainer) mapContainer.classList.remove("validation-error");
      }

      function hideEmptyState() {
         const emptyState = $(SELECTORS.emptyState);
         if (emptyState) {
            emptyState.classList.add("fade-out");
            setTimeout(() => (emptyState.style.display = "none"), 300);
         }
      }

      function showLocationSuccess() {
         const success = $(SELECTORS.locationSuccess);
         if (!success) return;

         success.style.display = "block";
         setTimeout(() => {
            success.style.transition = "opacity 0.3s";
            success.style.opacity = "0";
            setTimeout(() => {
               success.style.display = "none";
               success.style.opacity = "1";
            }, 300);
         }, 2000);
      }

      function clearLocation() {
         state.hasValidLocation = false;
         state.lastLatLng = {
            ...DEFAULT_POSITION
         };

         if (state.map && state.marker) {
            state.map.setCenter(state.lastLatLng);
            state.map.setZoom(13);
            state.marker.setPosition(state.lastLatLng);
         }

         const input = $(SELECTORS.input);
         if (input) {
            input.classList.remove("has-value");
            // Show warning if user has interacted with the field
            if (state.userInteracted) {
               showRequiredWarning();
            }
         }

         const emptyState = $(SELECTORS.emptyState);
         if (emptyState) {
            emptyState.classList.remove("fade-out");
            emptyState.style.display = "flex";
         }

         $(SELECTORS.coordsDisplay)?.style.setProperty("display", "none");
         $(SELECTORS.mapContainer)?.classList.remove("has-location");
         $(SELECTORS.addressHelper)?.style.setProperty("display", "none");

         window.Livewire?.dispatch("setAddress", {
            address: "",
            lat: "",
            lng: "",
         });
      }

      // Validation check function - can be called from parent component
      function validateLocation() {
         if (!state.hasValidLocation) {
            showRequiredWarning();
            const input = $(SELECTORS.input);
            if (input) {
               input.focus();
               input.scrollIntoView({
                  behavior: "smooth",
                  block: "center",
               });
            }
            return false;
         }
         return true;
      }

      // Expose validation function globally for Livewire
      window.validateAddressMap = validateLocation;

      // Input event listeners
      function setupInputListeners() {
         const input = $(SELECTORS.input);
         if (!input) return;

         input.addEventListener("focus", () => {
            state.userInteracted = true;
            if (!state.hasValidLocation && !input.value) {
               showValidationState(
                  "info",
                  "Start typing to search for an address",
               );
            }
         });

         input.addEventListener("blur", () => {
            // Show warning on blur if field is empty and user has interacted
            if (state.userInteracted && !state.hasValidLocation) {
               showRequiredWarning();
            }
         });

         input.addEventListener("input", (e) => {
            if (!e.target.value.trim()) {
               clearLocation();
            } else {
               // Hide warning when user starts typing
               hideRequiredWarning();
            }
         });

         input.addEventListener("keydown", (e) => {
            if (
               (e.key === "Backspace" || e.key === "Delete") &&
               !e.target.value
            ) {
               clearLocation();
            }
         });
      }

      // Initialization
      function tryInitMap() {
         if (window.google?.maps) {
            setTimeout(initMap, 100);
         }
      }

      // Event listeners
      document.addEventListener("livewire:initialized", tryInitMap);
      document.addEventListener("google-maps-ready", tryInitMap);

      document.addEventListener("livewire:init", () => {
         Livewire.on("stepChanged", (step) => {
            if (step === 2) {
               setTimeout(() => {
                  if (state.map) {
                     google.maps.event.trigger(state.map, "resize");
                     state.map.setCenter(state.lastLatLng);
                  }
                  const input = $(SELECTORS.input);
                  if (input && !state.autocompleteInitialized) {
                     initAutocomplete(input);
                  }
               }, 300);
            }
         });

         // Listen for validation errors from parent component
         Livewire.on("validationErrors", (data) => {
            if (data.step === 2 && data.errors?.address) {
               showRequiredWarning();
            }
         });
      });

      document.addEventListener("livewire:navigating", () => {
         if (state.autocomplete) {
            google.maps.event.clearInstanceListeners(state.autocomplete);
         }
         Object.assign(state, {
            mapInitialized: false,
            autocompleteInitialized: false,
            hasValidLocation: false,
            userInteracted: false,
            map: null,
            marker: null,
            autocomplete: null,
            geocoder: null,
            streetView: null,
         });
      });

      // Initialize
      if (document.readyState === "loading") {
         document.addEventListener("DOMContentLoaded", () => {
            tryInitMap();
            setupInputListeners();
         });
      } else {
         tryInitMap();
         setupInputListeners();
      }
 })();
</script>