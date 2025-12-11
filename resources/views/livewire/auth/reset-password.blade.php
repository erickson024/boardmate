<div class="container py-5">
    <div class="col-md-5 mx-auto mb-3">
        <div class="text-start">
            <x-buttons.small-button href="{{ route('login') }}">
                <i class="bi bi-arrow-left-short"></i>
                Log In Boardmate
            </x-buttons.small-button>
        </div>
    </div>

    <div class="col-md-5 mx-auto">
        <h5 class="fw-semibold">Reset your password</h5>
        <p class="text-muted mb-3"><small>We recommend creating a strong password using random letters, numbers, and special characters.</small></p>

        @if (session('error'))
        <div class="alert alert-danger"><small>{{ session('error') }}</small></div>
        @endif

        <form wire:submit.prevent="resetPassword">
            <div class="form-floating mb-3">
                <input type="email" class="form-control border-dark shadow-none" wire:model="email" readonly>
                <label><small>Email</small></label>
            </div>

            <div class="mb-3">

                <div class="progress rounded mb-1" style="height: 3px;">
                    <div class="progress-bar 
                                    @if($strengthScore < 2) bg-danger 
                                    @elseif($strengthScore < 4) bg-warning 
                                    @else bg-success 
                                    @endif"
                        role="progressbar"
                        style="width: {{ ($strengthScore/5) * 100 }}%">
                    </div>
                </div>

                <x-inputs.floating-input
                    id="password"
                    label="Create New Password"
                    type="password"
                    model="password" />
            </div>

            <x-inputs.floating-input
                id="password_confirmation"
                label="Confirm New Password"
                type="password"
                model="password_confirmation" />

            <button class="btn btn-dark btn-sm w-100">
                <span wire:loading.remove wire:target="resetPassword">
                    reset password
                </span>
                <span wire:loading wire:target="resetPassword">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    changing password...
                </span>
            </button>
        </form>
    </div>
</div>