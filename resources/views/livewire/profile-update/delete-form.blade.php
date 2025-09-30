<div>
    <h6 class="mb-0">Delete Account</h6>
    <small class="mt-0">Once your account is deleted, all of its resources and data will be permanently removed.</small>

    <form wire:submit.prevent="deleteAccount" class="col-8 mt-3">
        <div class="form-floating mb-3">
            <input type="password" wire:model="password" class="form-control border-dark shadow-none" placeholder="Password">
            <label>Password</label>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-sm btn-danger">
                Permanently Delete Account
                <span class="spinner-border spinner-border-sm" wire:loading wire:target="deleteAccount"></span>
            </button>
        </div>
    </form>
</div>
