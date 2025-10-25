<div>


    <div>
        <h6 class="mb-0">Profile</h6>
        <small class="mt-0">Update your name, profile photo and address.</small>

        <div class="row mt-3 gx-3">
            <div class="col-12 col-lg-3">
                <div class="p-2 text-center bg-light d-flex flex-column align-items-center justify-content-center shadow border border-dark rounded">
                    <input id="avatar-input" type="file" wire:model="avatar" accept="image/*" hidden>

                    <div id="circlePreview"
                        class="rounded-circle d-flex align-items-center justify-content-center shadow"
                        onclick="document.getElementById('avatar-input').click();"
                        style="width: 120px; height: 120px; overflow: hidden; cursor: pointer; border: none">

                        @if ($photo)
                        <img src="{{ $photo->temporaryUrl() }}" alt="Profile Preview" class="w-100 h-100" style="object-fit: cover;">
                        @elseif ($this->userAvatar)
                        <img src="{{ $this->userAvatar }}" alt="Profile Photo" class="w-100 h-100" style="object-fit: cover;">
                        @else
                        <div class="d-flex align-items-center justify-content-center w-100 h-100 bg-dark text-white"
                            style="font-size: 48px; font-weight: 600;">
                            {{ strtoupper(substr(auth()->user()->firstname, 0, 1)) }}
                        </div>
                        @endif
                    </div>

                    <div class="text-center">


                        <div class="d-flex justify-content-center align-items-center gap-1 mt-2">
                            <!-- Upload New Photo -->
                            <label class="btn btn-sm btn-dark mb-0">
                                <input type="file" wire:model="photo" class="d-none" accept="image/*">
                                <span wire:loading.remove wire:target="photo">
                                    <small>Upload New Photo</small>
                                </span>
                                <span wire:loading wire:target="photo">
                                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                    <small>Uploading...</small>
                                </span>
                            </label>

                            <!-- Remove Photo -->
                            @if ($hasPhoto)
                            <button wire:click="removePhoto" wire:loading.attr="disabled"
                                class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                            @endif
                        </div>

                    </div>
                    @error('photo') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
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


</div>