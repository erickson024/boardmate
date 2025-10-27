<div>
    <h6 class="mb-0">Update Password</h6>
    <small class="mt-0">Ensure your account is using a long, random password to stay secure.</small>

    @if(Auth::user()->google_id)
    @if(!$showSetPasswordForm)
    <div class="alert alert-light mt-3">
        <p><small>Since you signed up with Google, you may want to set a custom password for additional login options.</small></p>
        <button wire:click="showPasswordForm" class="btn btn-sm btn-dark">Set Custom Password</button>
    </div>
    @else
    <form wire:submit.prevent="updatePassword" class="col-8 mt-3">
        <div class="form-floating mb-3">
            <input
                type="password"
                wire:model="new_password"
                class="form-control border-dark shadow-none"
                placeholder="New Password"
                required>
            <label class="text-dark"><small>New Password</small></label>
            @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="password"
                wire:model="new_password_confirmation"
                class="form-control border-dark shadow-none"
                placeholder="Confirm New Password">
            <label class="text-dark"><small>Confirm New Password</small></label>
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-sm btn-dark">Set Password</button>
            <button type="button" wire:click="hidePasswordForm" class="btn btn-sm btn-outline-dark">Cancel</button>

            @if (session()->has('success'))
            <div class="alert alert-success mb-0 py-1 px-2">
                <small>{{ session('success') }}</small>
            </div>
            @endif
        </div>
    </form>
    @endif
    @else
    {{-- Regular user password form remains unchanged --}}
    <form wire:submit.prevent="updatePassword" class="col-8 mt-3">
        <div class="form-floating mb-3">
            <input
                type="password"
                wire:model="current_password"
                class="form-control border-dark shadow-none"
                placeholder="Current Password"
                required>
            <label class="text-dark"><small>Current Password</small></label>
            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-floating mb-3">
            <input
                type="password"
                wire:model="new_password"
                class="form-control border-dark shadow-none"
                placeholder="New Password"
                required>
            <label class="text-dark"><small>New Password</small></label>
            @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="password"
                wire:model="new_password_confirmation"
                class="form-control border-dark shadow-none"
                placeholder="Confirm New Password">
            <label class="text-dark"><small>Confirm New Password</small></label>
        </div>

        <div class="col-12 mt-1 d-flex align-items-center gap-2">
            <button
                type="submit"
                class="btn btn-sm btn-dark"
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="updatePassword">
                    Update Password
                </span>
                <span wire:loading wire:target="updatePassword">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Updating...
                </span>
            </button>

            @if (session()->has('success'))
            <div class="alert alert-success mb-0 py-1 px-2">
                <small><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</small>
            </div>
            @endif
        </div>
    </form>
    @endif
</div>