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
            <h5 class="fw-semibold mb-3">Reset your password</h5>

            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form wire:submit.prevent="resetPassword">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control border-dark shadow-none" wire:model="email" readonly>
                    <label><small>Email</small></label>
                </div>

                <div class="form-floating ">
                    <input type="password" class="form-control border-dark shadow-none" wire:model.live="password" placeholder="New password" required>
                    <label><small>New Password</small></label>
                </div>
                <div class="progress rounded mt-1 mb-3" style="height: 3px;">
                    <div class="progress-bar 
                                    @if($strengthScore < 2) bg-danger 
                                    @elseif($strengthScore < 4) bg-warning 
                                    @else bg-success 
                                    @endif"
                        role="progressbar"
                        style="width: {{ ($strengthScore/5) * 100 }}%">
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control border-dark shadow-none" wire:model="password_confirmation" placeholder="Confirm password" required>
                    <label><small>Confirm Password</small></label>
                </div>

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

</div>