<div class="container py-3">
    <div class="row">
        <div class="d-flex flex-column align-items-center">
            <div class="col-md-6  mb-3">
                <div class="">
                    <x-buttons.small-button href="{{ route('login') }}" class="fw-semibold">
                        <i class="bi bi-arrow-left-short"></i>
                        Log In Boardmate
                    </x-buttons.small-button>
                </div>
            </div>

            <div class="col-md-6  rounded shadow p-4">
                <h5 class="fw-semibold">Reset your password</h5>
                <p class="text-muted mb-3"><small>We recommend creating a strong password using random letters, numbers, and special characters.</small></p>

                @if (session('error'))
                <div class="alert alert-danger"><small>{{ session('error') }}</small></div>
                @endif

                <form wire:submit.prevent="resetPassword">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control border-dark shadow-none" wire:model="email" readonly>
                                <label><small>Email</small></label>
                            </div>
                        </div>

                        <div class="col-12 mb-3">

                            <x-indicators.password-strength :strength-score="$strengthScore" />
                            <x-floating-labels.input
                                id="password"
                                label="Create New Password"
                                type="password"
                                wire:model.live="password"
                                required />
                        </div>

                        <div class="col-12 mb-3">
                            <x-floating-labels.input
                                id="password_confirmation"
                                label="Confirm New Password"
                                type="password"
                                wire:model="password_confirmation"
                                required />
                        </div>

                        <div class="col-12">
                            <button class="btn btn-dark btn-sm w-100 fw-semibold">
                                <span wire:loading.remove wire:target="resetPassword">
                                    <small>reset password</small>
                                </span>
                                <span wire:loading wire:target="resetPassword">
                                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                    <small>changing password...</small>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>