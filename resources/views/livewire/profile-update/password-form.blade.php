<div>
    <h6 class="mb-0">Update Password</h6>
    <small class="mt-0">Ensure your account is using a long, random password to stay secure.</small>

    <form wire:submit.prevent="updatePassword" class="col-8 mt-3">
        <div class="form-floating mb-3">
            <input type="password" wire:model="current_password" class="form-control border-dark shadow-none" placeholder="Current Password">
            <label>Current Password</label>
            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="password" wire:model="new_password" class="form-control border-dark shadow-none" placeholder="New Password">
            <label>New Password</label>
            @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="password" wire:model="new_password_confirmation" class="form-control border-dark shadow-none" placeholder="Confirm New Password">
            <label>Confirm New Password</label>
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-sm btn-dark">Update Password</button>

            @if (session()->has('success'))
                <div class="alert alert-success mb-0 py-1 px-2">
                    <small>{{ session('success') }}</small>
                </div>
            @endif
        </div>
    </form>
</div>
