<div>
    @if (session()->has('profile-image-message'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('profile-image-message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">
        <div class="col-12">
            <h5 class="mb-1 fw-semibold">Profile Image</h5>
            <p class="text-muted small mb-0">Upload a profile picture to personalize your account.</p>
        </div>

        <!-- Single Unified Card -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Header -->
                    <div class="d-flex align-items-center gap-3 mb-4 pb-4 border-bottom">
                        <div class="rounded-3 bg-dark d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-cloud-arrow-up text-white" style="font-size: 24px;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">Upload New Image</h6>
                            <small class="text-muted">Select an image file from your device</small>
                        </div>
                    </div>

                    <!-- Current Profile Image Section -->
                    <div class="row g-4 align-items-center mb-4 pb-4 border-bottom">
                        <div class="col-auto">
                            <div class="position-relative">
                                @if($currentProfileImage)
                                <div class="position-relative" style="width: 140px; height: 140px;">
                                    <img
                                        src="{{ Storage::url($currentProfileImage) }}"
                                        alt="Profile Image"
                                        class="rounded-circle shadow-sm"
                                        style="width: 100%; height: 100%; object-fit: cover; border: 4px solid #f8f9fa;">
                                    <div class="position-absolute"
                                        style="bottom: 8px; right: 8px; width: 36px; height: 36px; background-color: #198754; border-radius: 50%; border: 4px solid white; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                        <i class="bi bi-check-lg text-white" style="font-size: 16px; font-weight: 700;"></i>
                                    </div>
                                </div>
                                @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                    style="width: 140px; height: 140px; background-color: #212529; border: 4px solid #f8f9fa;">
                                    @php
                                    $user = Auth::user();
                                    $firstInitial = strtoupper(substr($user->first_name ?? '', 0, 1));
                                    $lastInitial = strtoupper(substr($user->last_name ?? '', 0, 1));
                                    $initials = trim($firstInitial . $lastInitial);
                                    if (empty($initials)) {
                                    $initials = strtoupper(substr($user->name ?? $user->email ?? 'U', 0, 1));
                                    }
                                    @endphp
                                    <span class="text-white" style="font-size: 3.5rem; font-weight: 600; letter-spacing: -0.02em;">
                                        {{ $initials }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="col">
                            @if($currentProfileImage)
                            <div class="mb-3">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <h6 class="mb-0 fw-semibold" style="color: #212529;">Current Profile Picture</h6>
                                    <span class="badge bg-light text-dark border" style="font-size: 11px; padding: 4px 10px; font-weight: 600;">
                                        ACTIVE
                                    </span>
                                </div>
                                <p class="mb-0 text-muted" style="font-size: 14px;">
                                    Your profile picture is visible to other users
                                </p>
                            </div>
                            <div>
                                <button
                                    type="button"
                                    class="btn btn-outline-danger btn-sm"
                                    wire:click="removeProfileImage"
                                    wire:loading.attr="disabled"
                                    wire:target="removeProfileImage">
                                    <i class="bi bi-trash3 me-1"></i>
                                    <span wire:loading.remove wire:target="removeProfileImage">Remove Image</span>
                                    <span wire:loading wire:target="removeProfileImage">
                                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                        Removing...
                                    </span>
                                </button>
                            </div>
                            @else
                            <div>
                                <div class="mb-2">
                                    <h6 class="mb-1 fw-semibold" style="color: #212529;">No Profile Picture</h6>
                                    <span class="badge bg-light text-muted border" style="font-size: 11px; padding: 4px 10px; font-weight: 600;">
                                        NOT SET
                                    </span>
                                </div>
                                <p class="mb-0 text-muted" style="font-size: 14px;">
                                    Upload an image to make your profile stand out
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Preview Section (if image selected) -->
                    @if($profileImage)
                    <div class="row g-4 align-items-center mb-4 pb-4 border-bottom">
                        <div class="col-auto">
                            <div class="position-relative">
                                <img
                                    src="{{ $profileImage->temporaryUrl() }}"
                                    alt="New Profile Image Preview"
                                    class="rounded-circle shadow"
                                    style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #212529;">
                                <div class="position-absolute"
                                    style="bottom: 8px; right: 8px; width: 36px; height: 36px; background-color: #212529; border-radius: 50%; border: 4px solid white; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-eye text-white" style="font-size: 16px;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-2">
                                <h6 class="mb-0 fw-semibold" style="color: #212529;">Preview New Image</h6>
                            </div>
                            <p class="mb-0 text-muted" style="font-size: 14px;">
                                This is how your new profile picture will look
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Upload Form -->
                    <form wire:submit.prevent="updateProfileImage">
                        <!-- Drag & Drop Zone -->
                        <div class="mb-4">
                            <label for="profileImage" class="form-label fw-medium mb-3" style="font-size: 14px;">Image File</label>

                            <div class="position-relative">
                                <input
                                    type="file"
                                    class="form-control form-control-lg @error('profileImage') is-invalid @enderror"
                                    id="profileImage"
                                    wire:model="profileImage"
                                    accept="image/*"
                                    style="height: 120px; border: 2px dashed #dee2e6; border-radius: 8px; cursor: pointer; padding-top: 45px; text-align: center; background-color: #f8f9fa;">

                                @if(!$profileImage)
                                <div class="position-absolute top-50 start-50 translate-middle text-center" style="pointer-events: none; width: 100%;">
                                    <div class="mb-2">
                                        <i class="bi bi-image" style="font-size: 32px; color: #6c757d;"></i>
                                    </div>
                                    <p class="mb-1 fw-medium text-dark">Click to browse or drag and drop</p>
                                    <small class="text-muted">JPEG, PNG, JPG or GIF up to 2MB</small>
                                </div>
                                @endif
                            </div>

                            @error('profileImage')
                            <div class="text-danger small mt-2">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Requirements -->
                        <div class="bg-light border-0 rounded p-3 mb-4">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="bi bi-info-circle text-secondary" style="font-size: 18px;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-2 fw-semibold" style="font-size: 13px;">Image Requirements</h6>
                                    <ul class="mb-0 ps-3 small text-muted" style="line-height: 1.8;">
                                        <li>Maximum file size: <strong class="text-dark">2MB</strong></li>
                                        <li>Accepted formats: <strong class="text-dark">JPEG, PNG, JPG, GIF</strong></li>
                                        <li>Recommended: <strong class="text-dark">Square aspect ratio</strong> for best results</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Loading State -->
                        <div wire:loading wire:target="profileImage" class="mb-4">
                            <div class="bg-light rounded p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="spinner-border text-dark" role="status" style="width: 32px; height: 32px;">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-medium text-dark">Processing your image...</p>
                                        <small class="text-muted">This may take a few moments</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @if($profileImage)
                        <div class="d-flex gap-2 pt-3 border-top">
                            <button
                                type="submit"
                                class="btn btn-dark px-4 py-2 fw-medium"
                                wire:loading.attr="disabled"
                                wire:target="updateProfileImage"
                                style="min-width: 160px;">
                                <i class="bi bi-check-circle me-2"></i>
                                <span wire:loading.remove wire:target="updateProfileImage">Upload Image</span>
                                <span wire:loading wire:target="updateProfileImage">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    Uploading...
                                </span>
                            </button>
                            <button
                                type="button"
                                class="btn btn-outline-secondary px-4 py-2 fw-medium"
                                wire:click="$set('profileImage', null)">
                                <i class="bi bi-x-lg me-2"></i>
                                Cancel
                            </button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        #profileImage:hover {
            border-color: #adb5bd !important;
            background-color: #ffffff !important;
        }

        #profileImage:focus {
            border-color: #212529 !important;
            background-color: #ffffff !important;
            box-shadow: 0 0 0 0.25rem rgba(33, 37, 41, 0.1);
            outline: none;
        }

        input[type="file"]::file-selector-button {
            display: none;
        }

        .btn-outline-danger:hover,
        .btn-dark:hover,
        .btn-outline-secondary:hover {
            transform: translateY(-1px);
        }
    </style>
</div>