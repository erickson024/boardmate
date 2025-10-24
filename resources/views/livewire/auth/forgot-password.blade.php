<div>
    <div class="container py-5">
        <div class="col-md-5 mx-auto mb-3">
             <div class="text-start">
                <a href="{{ route('login') }}" class="btn btn-sm btn-dark" wire:navigate>
                    <i class="bi bi-arrow-left-short"></i>
                    Login
                </a>
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
                <div class="form-floating mb-3">
                    <input type="email" class="form-control border-dark shadow-none" wire:model="email" placeholder="Email">
                    <label><small>email address</small></label>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                 <button class="btn btn-dark btn-sm w-100">
                    <span wire:loading.remove wire:target="sendResetLink">
                        send reset link
                    </span>
                    <span wire:loading wire:target="sendResetLink">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        sending...
                    </span>
                </button>
            </form>
        </div>
    </div>

</div>