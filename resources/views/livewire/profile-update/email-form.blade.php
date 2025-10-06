<div>
    <h6 class="mb-0">Update Email</h6>
    <small class="mt-0">Change your email address (you’ll need to verify again).</small>

    <form wire:submit.prevent="updateEmail" class="col-8 mt-3">
        <div class="form-floating mb-3">
            <input type="email" wire:model="email" class="form-control border-dark shadow-none" placeholder="email@example.com">
            <label>Email</label>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-sm btn-dark">Update Email

            <span class="spinner-border spinner-border-sm" wire:loading wire:target="updateEmail"></span>
            </button>

            @if (session()->has('success'))
                <div class="alert alert-success mb-0 py-1 px-2">
                    <small>{{ session('success') }}</small>
                </div>
            @endif
        </div>
    </form>
</div>
