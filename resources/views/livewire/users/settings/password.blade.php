<div>
    <form wire:submit.prevent="updatePassword">
        <div class="row mb-3">
            <div class="col-12">
                <h6 class="mb-0">Update Password</h6>
                <small class="mt-0">Ensure your account is using a long, random password to stay secure.</small>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-7">
                <x-floating-labels.input
                    type="password"
                    id="currentPassword"
                    label="Current Password"
                    wire:model="currentPassword"
                    wire:loading.attr="disabled"
                    wire:target="updatePassword"
                    required />
            </div>

            <div class="col-lg-7">
                <x-indicators.password-strength :strength-score="$strengthScore" />
                <x-floating-labels.input
                    type="password"
                    id="newPassword"
                    label="Create New Password"
                    wire:model.live="newPassword"
                    wire:loading.attr="disabled"
                    wire:target="updatePassword"
                    required />
            </div>

            <div class="col-lg-7">
                <x-floating-labels.input
                    type="password"
                    id="confirmNewPassword"
                    label="Confirm New Password"
                    wire:model="confirmNewPassword"
                    wire:loading.attr="disabled"
                    wire:target="updatePassword"
                    required />
            </div>

            <div class="col-12">
                <x-buttons.small-button
                    type="submit"
                    action="updatePassword"
                    class="w-25 fw-semibold"
                    wire:loading.attr="disabled"
                    wire:target="updatePassword">
                    Update
                </x-buttons.small-button>
            </div>

            <div class="col-12">
                @if (session()->has('password-message'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <small>{{ session('password-message') }}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
        </div>
    </form>
</div>