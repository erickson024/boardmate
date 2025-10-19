<div>
    <span class="fs-6 fw-medium">Upload your Profile Picture.</span>
    <p><small>Click the camera icon below to upload your profile picture</small></p>

    <div class="d-flex flex-column align-items-center my-4">
    <!-- Profile image upload area -->
    <div class="position-relative profile-upload-wrapper">
        <!-- Circle image preview -->
        <label for="profilePhotoInput"
               class="d-block rounded-circle overflow-hidden border shadow position-relative"
               style="width: 200px; height: 200px; cursor: pointer;">
            @if ($profile_photo)
                <img src="{{ $profile_photo->temporaryUrl() }}"
                     class="w-100 h-100 object-fit-cover"
                     alt="Profile Preview">
            @else
                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-white">
                    <i class="bi bi-person fs-1 text-secondary"></i>
                </div>
            @endif
        </label>

        <!-- Hidden file input -->
        <input type="file" id="profilePhotoInput" wire:model="profile_photo"
               accept="image/*" class="d-none">

        <!-- Camera icon overlay -->
        <button type="button"
                class="position-absolute bottom-0 end-0 btn btn-dark rounded-circle shadow d-flex align-items-center justify-content-center"
                style="width: 50px; height: 50px; z-index: 2;"
                onclick="document.getElementById('profilePhotoInput').click()"
                wire:loading.class=""
                wire:target="profile_photo">
            <!-- Show spinner when loading -->
            <span wire:loading wire:target="profile_photo">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
            <!-- Show camera icon when not loading -->
            <i class="bi bi-camera-fill" wire:loading.remove wire:target="profile_photo"></i>
        </button>
    </div>
</div>

    @error('profile_photo')
    <small class="text-danger mt-2">{{ $message }}</small>
    @enderror

    <form wire:submit.prevent="submit" class="mt-4 d-flex justify-content-between">
        <button type="button" class="btn btn-sm btn-outline-dark" wire:click="back">
            <span>Back</span>
            <span wire:loading wire:target="back">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
        </button>
        <button type="submit" class="btn btn-sm btn-dark" wire:click="submit">
            <span>Continue</span>
            <span wire:loading wire:target="submit">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
        </button>
    </form>

<style>
    @keyframes profilePulse {
        0% {
            transform: scale(1);
            border-color: rgba(33, 37, 41, 0.8);
        }
        50% {
            transform: scale(1.05);
            border-color: rgba(33, 37, 41, 0.2);
        }
        100% {
            transform: scale(1);
            border-color: rgba(33, 37, 41, 0.8);
        }
    }

    .profile-upload-wrapper {
        position: relative;
        width: 200px;
        height: 200px;
        z-index: 0;
    }

    .profile-upload-wrapper::after {
        content: '';
        position: absolute;
        top: -8px;
        left: -8px;
        right: -8px;
        bottom: -8px;
        border: 2px solid #212529;
        border-radius: 50%;
        animation: profilePulse 2s ease-in-out infinite;
        z-index: 1;
    }
</style>
</div>