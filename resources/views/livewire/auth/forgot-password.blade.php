<div class="container py-5 mt-5">
    <div class="col-md-5 mx-auto mb-3">
        <div class="text-start">
            <x-buttons.small-button href="{{ route('login') }}" class="fw-semibold">
                <i class="bi bi-arrow-left-short"></i>
                Log In Boardmate
            </x-buttons.small-button>
        </div>
    </div>
    <div class="col-md-5 mx-auto">
        <h5 class="fw-semibold mb-3">Forgot your password?</h5>
        <p class="text-muted mb-4"><small>Enter your email address and we’ll send you a link to reset your password.</small></p>

        @if (session('message'))
        <div class="alert alert-success"><small>{{ session('message') }}</small></div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form wire:submit.prevent="sendResetLink">
            <x-inputs.floating-input
                id="email"
                label="email address"
                type="email"
                model="email" />

            <button class="btn btn-dark btn-sm w-100 fw-semibold">
                <span wire:loading.remove wire:target="sendResetLink">
                    <small>send reset link</small>
                </span>
                <span wire:loading wire:target="sendResetLink">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    <small>sending...</small>
                </span>
            </button>
        </form>
    </div>
</div>