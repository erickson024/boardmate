<div class="container-fluid">
    <div class="row bg-white shadow p-4 rounded">
        <div class="col-md-12">
            <h5 class="mb-0 fw-semibold">Profile Information</h5>
            <small class="text-muted">Manage your profile and account settings.</small>
            <hr class="my-4 border-secondary">
        </div>

        <!-- Sidebar menu -->
        <div class="col-md-3 d-flex flex-column nav nav-pills  gap-3" id="settings-menu" role="tablist">
            <button class="btn btn-sm btn-outline-dark text-start active" data-bs-toggle="pill" data-bs-target="#profile">Profile</button>
            <button class="btn btn-sm btn-outline-dark text-start" data-bs-toggle="pill" data-bs-target="#password">Password</button>
            <button class="btn btn-sm btn-outline-dark text-start" data-bs-toggle="pill" data-bs-target="#delete">Delete</button>
            <button class="btn btn-sm btn-outline-dark text-start" data-bs-toggle="pill" data-bs-target="#appearance">Appearance</button>
        </div>

        <!-- Content area -->
        <div class="col-md-9 tab-content">
            <div class="tab-pane fade show active" id="profile">
                <h6 class="mb-0">Profile</h6>
                <small class="mt-0">Update your name, profile photo, address and email address.</small>

                <div class="row mt-3 gx-3">
                    <div class="col-md-3">
                        <div class="p-2 text-center bg-light d-flex flex-column align-items-center justify-content-center shadow border border-dark rounded">
                            <input type="file" id="avatar" wire:model="avatar" accept="image/*" hidden>

                            <!-- Avatar preview -->
                            <div id="circlePreview"
                                class="rounded-circle d-flex align-items-center justify-content-center bg-light shadow"
                                onclick="document.getElementById('avatar').click();"
                                style="width: 120px; height: 120px; overflow: hidden; cursor: pointer;">

                                @if ($avatar)
                                {{-- Preview new upload --}}
                                <img src="{{ $avatar->temporaryUrl() }}" alt="Profile Preview" class="w-100 h-100" style="object-fit: cover;">
                                @elseif (Auth::user()->avatar)
                                {{-- Show saved avatar --}}
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile Photo" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                {{-- Default icon --}}
                                <i class="bi bi-person fs-1"></i>
                                @endif
                            </div>

                            <div wire:loading wire:target="avatar" class="mt-2 text-muted small">Uploading...</div>

                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-outline-dark btn-sm" onclick="document.getElementById('avatar').click()">
                                    Upload New Photo
                                </button>
                            </div>

                            @error('avatar')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Profile form -->
                    <div class="col-md-9">
                        <div class="row gx-3">

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control border-dark text-dark shadow-none" id="firstnameInput"
                                        placeholder="John" wire:model="firstname">
                                    <label for="firstnameInput" class="text-dark">Firstname</label>
                                    @error('firstname') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control border-dark text-dark shadow-none" id="lastnameInput"
                                        placeholder="Doe" wire:model="lastname">
                                    <label for="lastnameInput" class="text-dark">Lastname</label>
                                    @error('lastname') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control border-dark text-dark shadow-none" id="emailInput"
                                        placeholder="email@example.com" wire:model="email">
                                    <label for="emailInput" class="text-dark">Email</label>
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input type="address" class="form-control border-dark text-dark shadow-none" id="addressInput"
                                        placeholder="address" wire:model="address">
                                    <label for="addressInput" class="text-dark">Address</label>
                                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-1 d-flex align-items-center gap-2">
                                <!-- Update Button -->
                                <button wire:click="updateProfile" class="btn btn-sm btn-dark">
                                    Update Profile

                                    <span class="spinner-border spinner-border-sm"
                                        role="status"
                                        aria-hidden="true"
                                        wire:loading
                                        wire:target="updateProfile"></span>
                                </button>

                                <!-- Success Message -->
                                @if (session()->has('success'))
                                <div class="alert alert-success mb-0 py-1 px-2">
                                    <small>{{ session('success') }}</small>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <div class="tab-pane fade" id="password">

                <h6 class="mb-0">Update Password</h6>
                <small class="mt-0">Ensure your account is using a long, random password to stay secure.</small>


                <div class="col-8 mt-3">
                    <div class="form-floating mb-3">
                        <input type="password"
                            wire:model="current_password"
                            class="form-control border-dark shadow-none"
                            placeholder="Current Password">
                        <label>Current Password</label>
                        @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password"
                            wire:model="new_password"
                            class="form-control border-dark shadow-none"
                            placeholder="New Password">
                        <label>New Password</label>
                        @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password"
                            wire:model="new_password_confirmation"
                            class="form-control border-dark shadow-none"
                            placeholder="Confirm New Password">
                        <label>Confirm New Password</label>
                    </div>

                    <!-- Button + Success Alert in Same Row -->
                    <div class="d-flex align-items-center gap-2">
                        <button wire:click="updatePassword" class="btn btn-sm btn-dark">
                            Update Password
                        </button>

                        @if (session()->has('success'))
                        <div class="alert alert-success mb-0 py-1 px-2">
                            <small>{{ session('success') }}</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="delete">
                <h6>Deleting Account</h6>
                <p>Delete your account and all of its resources.</p>
            </div>
            <div class="tab-pane fade" id="appearance">
                <h6>Appearance Settings</h6>
                <p>Customize the theme and layout.</p>
            </div>
        </div>
    </div>
</div>