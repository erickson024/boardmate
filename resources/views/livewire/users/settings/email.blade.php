<div>
    @if (session()->has('email-message'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('email-message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form wire:submit.prevent="updateEmail">
        <div class="row g-3">
            <div class="col-12">
                <h6 class="mb-0">Update Email Address</h6>
                <small class="mt-0">Change the email address associated with your account. You'll need to verify your new email address.</small>
            </div>

            <!-- Current Email (Read-only) -->
            <div class="col-lg-7">
                <x-floating-labels.input
                    type="email"
                    id="currentEmail"
                    label="Current Email Address"
                    wire:model="currentEmail"
                    disabled
                    readonly />
            </div>

            <!-- New Email -->
            <div class="col-lg-7">
                <x-floating-labels.input
                    type="email"
                    id="newEmail"
                    label="New Email Address"
                    wire:model="newEmail"
                    wire:loading.attr="disabled"
                    wire:target="updateEmail"
                    required />
                @error('newEmail')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <x-buttons.small-button
                    type="submit"
                    action="updateEmail"
                    class="w-25 fw-semibold"
                    wire:loading.attr="disabled"
                    wire:target="updateEmail">
                    Update
                </x-buttons.small-button>
            </div>
        </div>
    </form>
</div>