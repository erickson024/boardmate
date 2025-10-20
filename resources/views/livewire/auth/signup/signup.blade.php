<div class=" d-flex flex-column ">
    <!-- Main Content Area with Scroll -->
    <div class="flex-grow-1s">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <!-- Left side: Form -->
                <div class="col-12 col-md-5 d-flex flex-column py-4">
                    <!-- Header -->
                    <div>
                        <h5 class="fw-medium mb-1">Get started</h5>
                        <p class="text-dark mb-0">
                            <small>Welcome to BoardMate — Let's create your account.</small>
                        </p>
                    </div>

                    <!-- Step Content -->
                    <div class="mt-4">
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

                <!-- Right side -->
                <div class="col-12 col-md-7 d-none d-md-block">
                    <!-- Content here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Fixed Step Dots (Outside scroll area) -->
    <div class="position-fixed bottom-0 start-50 translate-middle-x w-100 bg-white p-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-5">
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        @for ($i = 1; $i <= 4; $i++)
                            <div class="step-dot {{ $currentStep >= $i ? 'active' : '' }}"></div>
                            @if ($i < 4)
                                <div class="step-line {{ $currentStep > $i ? 'active' : '' }}"></div>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
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



