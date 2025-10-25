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
            <h5 class="fw-semibold">Reset your password</h5>
            <p class="text-muted mb-3"><small>We recommend creating a strong password using random letters, numbers, and special characters.</small></p>

            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form wire:submit.prevent="resetPassword">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control border-dark shadow-none" wire:model="email" readonly>
                    <label><small>Email</small></label>
                </div>
                
                <div class="mb-3">
                   
            
                <div class="form-floating ">
                    <input 
                    type="password" 
                    class="form-control border-dark shadow-none" 
                    wire:model.live="password" 
                    id="password"
                    placeholder="New password" 
                    required>
                    <label><small>New Password</small></label>

                    <button
                        type="button"
                        class="btn btn-sm btn-link position-absolute top-50 end-0 translate-middle-y me-2 text-secondary"
                        onclick="togglePassword('password', this)"
                        tabindex="-1">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div class="progress rounded mt-1 mb-2" style="height: 3px;">
                    <div class="progress-bar 
                                    @if($strengthScore < 2) bg-danger 
                                    @elseif($strengthScore < 4) bg-warning 
                                    @else bg-success 
                                    @endif"
                        role="progressbar"
                        style="width: {{ ($strengthScore/5) * 100 }}%">
                    </div>
                </div>
                 @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                

                <div class="form-floating mb-3">
                    <input 
                    type="password" 
                    class="form-control border-dark shadow-none" 
                    wire:model="password_confirmation" 
                    id="password_confirmation"
                    placeholder="Confirm password" 
                    required>
                    <label><small>Confirm Password</small></label>

                      <button
                        type="button"
                        class="btn btn-sm btn-link position-absolute top-50 end-0 translate-middle-y me-2 text-secondary"
                        onclick="togglePassword('password_confirmation', this)"
                        tabindex="-1">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror

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

    <style>
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
    </style>

    <script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }
</script>

</div>