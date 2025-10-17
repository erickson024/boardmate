<div>
    @php
    $userAvatar = auth()->user()->avatar;
    if ($userAvatar && !str_starts_with($userAvatar, 'http')) {
    // it's a local file
    $userAvatar = asset('storage/' . $userAvatar);
    } elseif (!$userAvatar) {
    // fallback to default
    $userAvatar = asset('images/default-avatar.png');
    }
    @endphp

    <h6 class="mb-0">Profile</h6>
    <small class="mt-0">Update your name, profile photo and address.</small>

    <div class="row mt-3 gx-3">
        <div class="col-12 col-lg-3">
            <div class="p-2 text-center bg-light d-flex flex-column align-items-center justify-content-center shadow border border-dark rounded">
                <input id="avatar-input" type="file" wire:model="avatar" accept="image/*" hidden>

                <div id="circlePreview"
                    class="rounded-circle d-flex align-items-center justify-content-center bg-light shadow"
                    onclick="document.getElementById('avatar-input').click();"
                    style="width: 120px; height: 120px; overflow: hidden; cursor: pointer;">

                    @if ($avatar)
                    <img src="{{ $avatar->temporaryUrl() }}" alt="Profile Preview" class="w-100 h-100" style="object-fit: cover;">
                    @else
                    <img src="{{ $userAvatar }}" alt="Profile Photo" class="w-100 h-100" style="object-fit: cover;">
                    @endif
                </div>

                <div wire:loading wire:target="avatar" class="mt-2 text-muted small">Uploading...</div>

                <div class="text-center mt-3">
                    <button type="button" class="btn btn-outline-dark btn-sm" onclick="document.getElementById('avatar-input').click()">
                        Upload New Photo
                    </button>
                </div>

                @error('avatar') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="col-12 col-lg-9">
            <form wire:submit.prevent="updateProfile">
                <div class="row gx-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control border-dark text-dark shadow-none" wire:model="firstname" placeholder="John">
                            <label class="text-dark">Firstname</label>
                            @error('firstname') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control border-dark text-dark shadow-none" wire:model="lastname" placeholder="Doe">
                            <label class="text-dark">Lastname</label>
                            @error('lastname') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control border-dark text-dark shadow-none" wire:model="address" placeholder="address">
                            <label class="text-dark">Address</label>
                            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-12 mt-1 d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-sm btn-dark">
                            Update Profile
                            <span class="spinner-border spinner-border-sm" wire:loading wire:target="updateProfile"></span>
                        </button>

                        @if (session()->has('success'))
                        <div class="alert alert-success mb-0 py-1 px-2">
                            <small>{{ session('success') }}</small>
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>