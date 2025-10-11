<div class="mb-4">
    <p class="fs-6 fw-medium mb-3">
        Upload clear images of your property. Minimum 1, maximum 5 images.
    </p>

    {{-- Uploading Indicator --}}
    <div wire:loading wire:target="newImages" class="alert alert-info py-2 small">
        Uploading images, please wait...
    </div>

    {{-- Preview Section --}}
    <div class="row row-cols-2 row-cols-md-3 g-3 justify-content-center">
        @foreach ($images as $key => $image)
            <div class="col">
                <div class="position-relative rounded-4 overflow-hidden shadow-sm border">
                    <img 
                        src="{{ $image->temporaryUrl() }}" 
                        class="img-fluid rounded-4" 
                        alt="Preview {{ $key }}"
                    >
                    <button 
                        type="button" 
                        class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm"
                        wire:click="removeImage({{ $key }})"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Upload Button --}}
    <div class="mt-4 text-center">
        @if (count($images) < 5)
            <label for="images" 
                class="d-inline-block p-5 border border-2 border-dashed rounded-4 w-100 text-muted hover-bg-light"
                style="cursor: pointer;">
                <i class="bi bi-cloud-arrow-up fs-3 d-block mb-2"></i>
                <span class="fw-medium">Click or drag images to upload</span>
                <small class="d-block">Maximum 5 images (2MB each)</small>
            </label>
            <input 
                type="file" 
                id="images" 
                name="images[]" 
                accept="image/*" 
                multiple 
                hidden 
                wire:model="newImages">
        @else
            <p class="text-muted mt-3"><small>You’ve reached the maximum of 5 images.</small></p>
        @endif
    </div>

    {{-- Validation Errors --}}
    <div class="mt-3">
        @error('newImages.*') 
            <div class="text-danger small">⚠ {{ $message }}</div> 
        @enderror

        @error('images')
            <div class="text-danger small">⚠ {{ $message }}</div>
        @enderror

        @if ($errors->has('upload_limit'))
            <div class="text-danger small">⚠ {{ $errors->first('upload_limit') }}</div>
        @endif
    </div>

    {{-- Navigation Buttons --}}
    <form wire:submit.prevent="submit" class="mt-4 d-flex justify-content-between">
        <button type="button" class="btn btn-outline-dark btn-sm" wire:click="back">
            Back
        </button>
        <button type="submit" class="btn btn-dark btn-sm">
            Continue
        </button>
    </form>

    <style>
        .hover-bg-light:hover {
            background-color: #f9f9f9;
            transition: background-color 0.2s ease-in-out;
        }
        .border-dashed {
            border-style: dashed !important;
        }
    </style>
</div>
