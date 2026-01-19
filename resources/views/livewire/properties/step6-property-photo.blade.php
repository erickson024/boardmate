<div class="step-6-property-photo">
    <div x-data="{ isDragging: false, uploadProgress: @entangle('uploadProgress').live, deletingPath: null}">
        <div class="row">
            {{-- Header --}}
            <div class="col-12 mb-3">
                <label class="form-label fw-semibold mb-1">
                    Property Photos <span class="text-danger">*</span>
                </label>
                <small class="text-muted d-block">
                    Upload clear, well-lit images of your property. Show different angles and important features.
                </small>
            </div>

            {{-- Upload Progress --}}
            <div class="col-12"
                wire:loading
                wire:target="images"
                x-transition>
                <div class="alert alert-primary border-0 py-2 mb-3 d-flex align-items-center">
                    <div class="spinner-border spinner-border-sm me-2" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="small">
                        Uploading images<span class="loading-dots"></span>
                    </span>
                </div>
            </div>

            {{-- Image Counter Badge --}}
            <div class="col-12 mb-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge rounded-pill"
                        :class="{{ count($storedImages) }} >= 1 ? 'bg-success' : 'bg-secondary'">
                        {{ count($storedImages) }} / 5 images
                    </span>
                    @if(count($storedImages) === 0)
                    <small class="text-muted">
                        Upload at least 1 image to continue
                    </small>
                    @elseif(count($storedImages) < 5)
                        <small class="text-success">
                        <i class="bi bi-check-circle-fill"></i>
                        Good! You can add {{ 5 - count($storedImages) }} more
                        </small>
                        @else
                        <small class="text-info">
                            <i class="bi bi-star-fill"></i>
                            Maximum reached!
                        </small>
                        @endif
                </div>
            </div>

            {{-- Preview Images Grid --}}
            <div class="col-12 mb-3">
                <div class="row g-3">
                    @foreach ($storedImages as $key => $image)
                    <div class="col-6 col-md-4"
                        wire:key="image-{{ $image }}"
                        x-data="{ isHovered: false, isDeleting: false }"
                        @mouseenter="isHovered = true"
                        @mouseleave="isHovered = false">
                        <div class="preview-card position-relative rounded-3 overflow-hidden shadow-sm border">
                            {{-- Image --}}
                            <div class="ratio ratio-4x3">
                                <img
                                    src="{{ asset('storage/' . $image) }}"
                                    class="object-fit-cover w-100 h-100"
                                    alt="Property image {{ $key + 1 }}"
                                    loading="lazy">
                            </div>

                            {{-- Image Number Badge --}}
                            <span class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 rounded-pill">
                                {{ $key + 1 }}
                            </span>

                            {{-- Primary Image Badge --}}
                            @if($key === 0)
                            <span class="position-absolute bottom-0 start-0 m-2 badge bg-primary rounded-pill">
                                <i class="bi bi-star-fill"></i> Cover
                            </span>
                            @endif

                            {{-- Delete Button (shows on hover) --}}
                            <div class="position-absolute top-0 end-0 m-2  d-flex align-items-center justify-content-center"

                                x-transition
                                style=" display: none;">
                                <button
                                    type="button"
                                    @click="isDeleting = true; deletingPath = '{{ $image }}'"
                                    wire:click="removeImage({{ $key }})"
                                    class="btn btn-danger btn-sm rounded-circle shadow"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Upload Box --}}
            <div class="col-12">
                @if (count($storedImages) < 5)
                    <label
                    for="images"
                    @dragover.prevent="isDragging = true"
                    @dragleave.prevent="isDragging = false"
                    @drop.prevent="isDragging = false"
                    :class="isDragging ? 'border-primary bg-primary bg-opacity-10' : 'border-secondary'"
                    class="upload-box border border-2 border-dashed rounded-4 p-4 p-md-5 w-100 text-center position-relative"
                    style="cursor: pointer; transition: all 0.3s ease;">

                    {{-- Upload Icon --}}
                    <div :class="isDragging ? 'text-primary' : 'text-muted'">
                        <i class="bi fs-1 mb-3 d-block"
                            :class="isDragging ? 'bi-cloud-check-fill' : 'bi-cloud-arrow-up'"></i>

                        <p class="fw-semibold mb-1" x-show="!isDragging">
                            Click to upload or drag and drop
                        </p>
                        <p class="fw-semibold mb-1 text-primary" x-show="isDragging" style="display: none;">
                            Drop images here
                        </p>

                        <small class="d-block text-muted">
                            JPG, PNG or WEBP (max 2MB each)
                        </small>
                        <small class="d-block text-muted">
                            {{ 5 - count($storedImages) }} {{ count($storedImages) === 4 ? 'slot' : 'slots' }} remaining
                        </small>
                    </div>
                    </label>

                    <input
                        type="file"
                        id="images"
                        class="d-none"
                        accept="image/jpeg,image/png,image/webp"
                        multiple
                        wire:model="images">
                    @else
                    <div class="alert alert-success border-0 d-flex align-items-center justify-content-center py-4">
                        <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                        <div>
                            <strong>All set!</strong>
                            <small class="d-block">You've uploaded the maximum of 5 images</small>
                        </div>
                    </div>
                    @endif
            </div>

            {{-- Helpful Tips --}}
            @if(count($storedImages) === 0)
            <div class="col-12 mt-3">
                <div class="alert alert-light border">
                    <small class="fw-semibold d-block mb-2">
                        <i class="bi bi-lightbulb text-warning"></i> Photography Tips:
                    </small>
                    <ul class="small mb-0 ps-3">
                        <li>Use natural lighting when possible</li>
                        <li>Show the room from multiple angles</li>
                        <li>Include important features (kitchen, bathroom, etc.)</li>
                        <li>Keep the space clean and organized</li>
                    </ul>
                </div>
            </div>
            @endif

            {{-- Validation Errors --}}
            @error('images')
            <div class="col-12 mt-3">
                <div class="alert alert-danger border-0 py-2 d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <small>{{ $message }}</small>
                </div>
            </div>
            @enderror

            @error('images.*')
            <div class="col-12 mt-2">
                <div class="alert alert-danger border-0 py-2 d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <small>{{ $message }}</small>
                </div>
            </div>
            @enderror
        </div>
    </div>
</div>