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

        <!-- Minimal Horizontal Card -->
        <div class="col-12">
            <div class="card border shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-4">
                        <!-- Profile Image -->
                        <div class="flex-shrink-0">
                            @if($currentProfileImage)
                            <img
                                src="{{ Storage::url($currentProfileImage) }}"
                                alt="Profile Image"
                                class="rounded-circle"
                                style="width: 80px; height: 80px; object-fit: cover;">
                            @elseif($profileImage)
                            <img
                                src="{{ $profileImage->temporaryUrl() }}"
                                alt="New Profile Image Preview"
                                class="rounded-circle"
                                style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px; background-color: #e9ecef;">
                                @php
                                $user = Auth::user();
                                $firstInitial = strtoupper(substr($user->firstName ?? '', 0, 1));
                                $lastInitial = strtoupper(substr($user->lastName ?? '', 0, 1));
                                $initials = trim($firstInitial . $lastInitial);
                                if (empty($initials)) {
                                $initials = strtoupper(substr($user->name ?? $user->email ?? 'U', 0, 1));
                                }
                                @endphp
                                <span class="text-secondary fw-semibold" style="font-size: 1.75rem;">
                                    {{ $initials }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Text Info -->
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-semibold">Profile picture</h6>
                            <p class="text-muted small mb-0">PNG, JPEG under 15MB</p>
                            @error('profileImage')
                            <p class="text-danger small mb-0 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex-shrink-0 d-flex gap-2">
                            <form wire:submit.prevent="updateProfileImage" class="d-inline">
                                <label for="profileImageInput" class="btn btn-sm btn-dark mb-0" style="cursor: pointer;">
                                    <span wire:loading.remove wire:target="profileImage">
                                        <small>
                                            Upload new picture
                                        </small>
                                    </span>
                                    <span wire:loading wire:target="profileImage">
                                        <small>
                                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                            Processing...
                                    </span>
                                    </small>
                                </label>
                                <input
                                    type="file"
                                    class="d-none"
                                    id="profileImageInput"
                                    wire:model="profileImage"
                                    accept="image/*">

                                @if($profileImage)
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-primary ms-1"
                                    wire:loading.attr="disabled"
                                    wire:target="updateProfileImage">
                                    <span wire:loading.remove wire:target="updateProfileImage">
                                        <small>Save</small>
                                    </span>
                                    <span wire:loading wire:target="updateProfileImage">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    </span>
                                </button>
                                @endif
                            </form>

                            @if($currentProfileImage)
                            <button
                                type="button"
                                class="btn btn-sm btn-danger"
                                wire:click="removeProfileImage"
                                wire:loading.attr="disabled"
                                wire:target="removeProfileImage">
                                <span wire:loading.remove wire:target="removeProfileImage">
                                    <small>Delete</small>
                                </span>
                                <span wire:loading wire:target="removeProfileImage">
                                    <small>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    </small>
                                </span>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>