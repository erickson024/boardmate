<div>
    <div class="row">
        <div class="col-6">
            <div class="mb-3" style="position: relative;">
                <div class="form-floating">
                    <input
                        type="text"
                        class="form-control border-dark text-dark shadow-none pe-5"
                        placeholder="Add an amenity"
                        id="amenity"
                        wire:model.defer="newAmenity"
                        wire:keydown.enter.prevent="addAmenity">
                    <label class="text-dark" for="amenity">Amenities</label>

                    <!-- Add Button inside input field -->
                    <button
                        type="button"
                        wire:click="addAmenity"
                        class="btn btn-dark position-absolute top-50 end-0 translate-middle-y me-1"
                        style="height: calc(100% - 0.50rem);">
                        Add
                    </button>
                </div>
                @error('amenities')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="col-6">
            <div class="d-flex flex-wrap gap-2 mt-2">
                @foreach ($amenities as $index => $amenity)
                <div class="d-inline-flex align-items-center bg-dark text-light rounded-pill px-3 py-1 shadow">
                    <span class="me-2">{{ $amenity }}</span>
                    <button
                        wire:click="removeAmenity({{ $index }})"
                        type="button"
                        class="btn-close btn-close-white btn-sm"
                        aria-label="Remove"></button>
                </div>
                @endforeach
            </div>

            <!-- Hidden inputs for form submission -->
            @foreach ($amenities as $amenity)
            <input type="hidden" name="amenities[]" value="{{ $amenity }}">
            @endforeach
        </div>
    </div>
</div>