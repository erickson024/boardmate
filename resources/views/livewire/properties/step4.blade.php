<div class="mb-4">

    @php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
    @endphp

    <p class="fs-6 fw-medium mb-3">
        Upload clear images of your property. Minimum 1, maximum 5 images.
    </p>

    {{-- Uploading Indicator --}}
    <div wire:loading wire:target="newImages" class="alert alert-info py-2 small">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span>Uploading images, please wait.</span>
    </div>

    {{-- Preview Section --}}
    <div class="row row-cols-2 row-cols-md-3 g-3 justify-content-center">
        @foreach ($images as $key => $image)
        @if ($image) <!-- Skip empty values -->
        <div class="col" >
            <div class="position-relative rounded-4 overflow-hidden shadow-sm border preview-image show">
                <img src="{{ asset('storage/' . $image) }}" alt="Preview" class="img-fluid rounded">

                <button wire:click="removeImage({{ $key }})" class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
        @endif
        @endforeach

    </div>

    {{-- Upload Button --}}
    <div class="mt-4 text-center">
        @if (count($images) < 5)
            <label for="images"
            class="d-inline-block p-5 border border-2 border-dashed rounded-4 w-100 text-muted hover-bg-light  show"
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
            <span class="fw-semibold small">Back</span>
            <span wire:loading wire:target="back">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
        </button>
        <button type="submit" class="btn btn-dark btn-sm">
             <span class="fw-semibold small">Continue</span>
            <span wire:loading wire:target="submit">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
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

    /* Container for each preview image */
    .preview-image {
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        opacity: 0;
        transform: scale(0.9);
        animation: fadeZoomIn 0.5s ease forwards;
    }

    /* The animation definition */
    @keyframes fadeZoomIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Slight hover zoom for interaction */
    .preview-image:hover img {
        transform: scale(1.05);
        transition: transform 0.3s ease-in-out;
    }

    /* Image styling */
    .preview-image img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s ease-in-out;
        border-radius: 10px;
    }

    /* Optional: Staggered animation per image */
    .preview-image:nth-child(1) { animation-delay: 0s; }
    .preview-image:nth-child(2) { animation-delay: 0.05s; }
    .preview-image:nth-child(3) { animation-delay: 0.1s; }
    .preview-image:nth-child(4) { animation-delay: 0.15s; }
    .preview-image:nth-child(5) { animation-delay: 0.2s; }
</style>

</div>