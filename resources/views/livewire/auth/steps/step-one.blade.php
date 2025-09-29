<div>
    <div class="row h-100">
        <p class="text-dark fs-6 fw-semibold mb-0">Step 1: Personal Infomation</p>
        <small class="mt-0 mb-3">Let’s get to know you! Fill in your name and where you live.</small>

        <div class="col-md-4 col-sm-12">
            {{-- Profile Upload --}}
            <div class="p-3 text-center bg-light d-flex flex-column align-items-center justify-content-center shadow border border-dark rounded">
                <input type="file" id="avatar" wire:model="avatar" class="d-none">

                <div id="circlePreview"
                    class="rounded-circle d-flex align-items-center justify-content-center bg-light shadow"
                    onclick="document.getElementById('avatar').click();"
                    style="width: 120px; height: 120px; overflow: hidden; cursor: pointer;">

                    @if ($avatar)
                    <img src="{{ $avatar->temporaryUrl() }}"
                        alt="Profile Preview"
                        class="w-100 h-100"
                        style="object-fit: cover;">
                    @else
                    <div class="profile-avatar text-center">
                        {{-- Show default profile icon (hidden during upload) --}}
                        <div wire:loading.remove wire:target="avatar">
                            <i class="bi bi-person fs-1"></i>
                        </div>

                        {{-- Show spinner during upload --}}
                        <div wire:loading wire:target="avatar">
                            <div class="spinner-grow text-dark" role="status">
                                <span class="visually-hidden">Uploading...</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div wire:loading wire:target="avatar" class="mt-2 text-muted small">
                    Uploading...
                </div>

                <div class="text-center mt-3">
                    <button class="btn btn-outline-dark btn-sm" onclick="document.getElementById('avatarInput').click()">
                        Upload Profile Photo
                    </button>
                </div>

                <!-- Hidden inputs -->
                <input type="file" id="avatarInput" wire:model="avatar" accept="image/*" hidden>


                @error('avatar')
                <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="col-md-8 col-sm-12 mt-3 mt-sm-3 mt-md-0 mt-lg-0">
            <div class="row gx-3">

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="form-floating mb-3">
                        <input type="text"
                            class="form-control border-dark text-dark shadow-none"
                            id="firstnameInput"
                            placeholder="John"
                            wire:model="firstname">
                        <label for="firstnameInput" class="text-dark">Firstname</label>
                        @error('firstname') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="form-floating mb-3">
                        <input type="text"
                            class="form-control border-dark text-dark shadow-none"
                            id="lastnameInput"
                            placeholder="Doe"
                            wire:model="lastname">
                        <label for="lastnameInput" class="text-dark">Lastname</label>
                        @error('lastname') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input type="text"
                            class="form-control border-dark text-dark shadow-none"
                            id="addressInput"
                            placeholder="123 Main St"
                            wire:model="address">
                        <label for="addressInput" class="text-dark">Address</label>
                        @error('address') <small class="text-danger">{{ $message }}</s> @enderror
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>