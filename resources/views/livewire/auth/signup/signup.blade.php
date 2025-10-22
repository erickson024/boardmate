<div>
    <div class="container-fluid flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center mt-3">
            <div class="col-12 col-md-5">
                <!-- Header -->
                <div>
                    <div class="mb-3 d-flex justify-content-between">
                        <div>
                            <button wire:click="goToDashboard" class="btn btn-dark btn-sm">
                                <i class="bi bi-arrow-left-short"></i>
                                <small>Boardmate Home</small>
                            </button>
                        </div>

                        <div>
                            <a href="{{route('login')}}"
                                class="btn btn-sm btn-dark"
                                wire:navigate><small>Log in</small></a>
                        </div>

                    </div>
                    <div class="d-flex align-items-end text-start mb-1">
                        <a class="navbar-brand fw-medium fs-6 me-1" href="">
                            <img src="{{ asset('images/logo.png') }}" alt="Bootstrap" width="45" height="40" class="d-inline-block align-text-center">
                        </a>
                        <h5 class="fw-semibold mb-0">Create an Account</h5>
                    </div>

                    <p class="text-dark mb-3">
                       <small class="text-muted">Choose Google sign up or continue with manual registration.</small>
                    </p>

                    <!-- Google Sign-in -->
                    <div class="text-center">
                        <a href="{{ route('google.redirect') }}" class="btn btn-sm btn-dark w-100">
                            <i class="bi bi-google me-2"></i> Sign up with Google
                        </a>
                    </div>

                    <div class="d-flex align-items-center">
                        <hr class="flex-grow-1">
                        <span class="mx-2 text-dark fw-medium"><small>or</small></span>
                        <hr class="flex-grow-1">
                    </div>
                </div>

                <!-- Step Content -->
                <div class="mb-3">
                    @if ($currentStep === 1)
                    <livewire:auth.signup.step1 />
                    @elseif ($currentStep === 2)
                    <livewire:auth.signup.step2 />
                    @elseif ($currentStep === 3)
                    <livewire:auth.signup.step3 />
                    @elseif ($currentStep === 4)
                    <livewire:auth.signup.step4 />
                    @endif
                </div>


            </div>
        </div>
    </div>

    <!-- Fixed Step Dots (Outside scroll area) -->
    <div class="position-fixed bottom-0 start-50 translate-middle-x w-100 bg-white py-2 ">
        <div class="d-flex justify-content-center align-items-center gap-3">
            @for ($i = 1; $i <= 4; $i++)
                <div class="step-dot {{ $currentStep >= $i ? 'active' : '' }}">
        </div>
        @if ($i < 4)
            <div class="step-line {{ $currentStep > $i ? 'active' : '' }}">
    </div>
    @endif
    @endfor
</div>
</div>

<style>
    /* Step Progress */
    .step-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background-color: #dee2e6;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .step-dot.active {
        background-color: #212529;
        transform: scale(1.3);
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