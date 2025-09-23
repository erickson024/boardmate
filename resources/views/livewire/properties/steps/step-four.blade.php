<div class="row overflow-auto" style="height: 80%;">

    <!-- Upload Section -->
    <div class="col-12">
        <label for="imagesInput"
            class="d-block border border-2 border-dashed rounded p-5 text-center bg-light"
            style="cursor: pointer;">

            <div class="mb-3">
                <i class="bi bi-cloud-upload text-primary" style="font-size: 2.5rem;"></i>
            </div>

            <p class=" text-muted">
                Drag & Drop multiple images here or
                <span class="text-primary">click to browse</span>
            </p>
        </label>

        <!-- Bind to newImages, not images -->

        <input id="imagesInput"
            type="file"
            wire:model="newImages"
            multiple
            accept="image/*"
            class="d-none">

        @error('newImages.*')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="text-center mt-2">
            <!-- Spinner shows only when uploading -->
            <div wire:loading wire:target="newImages">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Uploading...</span>
                </div>
                <p class="text-muted small mt-2">Uploading images...</p>
            </div>
        </div>
        @error('images') <small class="text-danger">{{ $message }}</small> @enderror

              <!-- Warning messages -->
                    @if(!empty($imageErrors))
                    <div class="mt-2">
                        @foreach($imageErrors as $warning)
                        <div class="alert alert-warning py-1 px-2 small mb-1">
                            {{ $warning }}
                        </div>
                        @endforeach
                    </div>
                    @endif
    </div>

    <!-- Preview Section -->
    <div class="col-8">
        @foreach($images as $index => $image)
        <div class="d-flex align-items-start border rounded p-2 mb-2 shadow-sm">
            <div class="me-2">
                <img src="{{ $image->temporaryUrl() }}"
                    alt="preview"
                    class="rounded"
                    style="width: 70px; height: 50px; object-fit: cover;">
            </div>
            <div class="flex-grow-1">
                <small class="text-muted d-block mb-1"
                    style="max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ $image->getClientOriginalName() }}
                </small>

                <div class="d-flex align-items-center">
                    <!-- Caption input grows -->
                    <input
                        type="text"
                        wire:model="captions.{{ $index }}"
                        placeholder="Caption"
                        class="form-control form-control-sm shadow-none flex-grow-1">

                    <!-- Remove button stays small -->
                    <button type="button"
                        wire:click="removeImage({{ $index }})"
                        class="btn btn-sm btn-danger ms-2">
                        Remove
                    </button>

                </div>

            </div>
        </div>
        @endforeach
    </div>

</div>