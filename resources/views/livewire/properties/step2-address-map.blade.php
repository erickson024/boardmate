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
            required/>

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

