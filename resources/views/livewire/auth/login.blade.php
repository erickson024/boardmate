<div>
    <div class="container-fluid flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="row w-100  justify-content-center mt-3">
            <div class="col-12 col-md-5">
                <!-- Header -->
                <div class="mb-3">
                    <div class="mb-3 d-flex justify-content-between">
                        <div>
                            <button wire:click="goToDashboard" class="btn btn-dark btn-sm">
                                <i class="bi bi-arrow-left-short"></i>
                                <small>Boardmate Home</small>
                            </button>
                        </div>

                        <div>
                            <a href="{{route('signup')}}"
                                class="btn btn-sm btn-dark"
                                wire:navigate><small>Sign up</small></a>
                        </div>

                    </div>
                    <div class="d-flex align-items-end text-start mb-1">
                        <a class="navbar-brand fw-medium fs-6 me-1" href="">
                            <img src="{{ asset('images/logo.png') }}" alt="Bootstrap" width="45" height="40" class="d-inline-block align-text-center">
                        </a>
                        <h5 class="fw-semibold mb-0">Log in to your Account</h5>
                    </div>

                    <p class="text-dark mb-3">
                        <small class="text-muted">Log in with Google or continue by filling out the form below.</small>
                    </p>

                    <!-- Google Sign-in -->
                    <div class="text-center">
                        <a href="{{ route('google.redirect') }}" class="btn btn-sm btn-dark w-100">
                            <i class="bi bi-google me-2"></i> Log in with Google
                        </a>
                    </div>

                    <div class="d-flex align-items-center">
                        <hr class="flex-grow-1">
                        <span class="mx-2 text-dark fw-medium"><small>or</small></span>
                        <hr class="flex-grow-1">
                    </div>
                </div>

                <div>
                    <form wire:submit.prevent="login">
                        @if (session('message'))
                        <div id="successAlert" class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <i class="bi bi-check-circle me-1"></i>
                            <small>{{ session('message') }}</small>
                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" ></button>
                        </div>
                        @endif

                        <div class="form-floating mb-3">
                            <input type="email"
                                class="form-control border-dark text-dark shadow-none"
                                id="emailInput"
                                placeholder="johndoe@gmail.com"
                                wire:model="email"
                                required>
                            <label for="emailInput" class="text-dark"><small>email</small></label>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-floating">
                            <input type="password"
                                class="form-control border-dark text-dark shadow-none"
                                id="password"
                                placeholder="@test123"
                                wire:model="password"
                                required>
                            <label for="password" class="text-dark"><small>password</small></label>

                            <button
                                type="button"
                                class="btn btn-sm btn-link position-absolute top-50 end-0 translate-middle-y me-2 text-secondary"
                                onclick="togglePassword('password', this)"
                                tabindex="-1">
                                <i class="bi bi-eye"></i>
                            </button>

                        </div>

                        <div>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="">
                            <div class="row mt-1">
                                <div class="col-6 d-flex justify-content-start">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input shadow-none border-dark"
                                            type="checkbox"
                                            value=""
                                            id="checkDefault"
                                            wire:model="remember">
                                        <label class="form-check-label" for="checkDefault">
                                            <small>Remember me</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                    <a href="{{ route('password.request') }}" class="link-underline-dark link-underline-opacity-0 link-underline-opacity-100-hover text-dark fw-medium" wire:navigate>
                                        <small>Forgot your Password?</small>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <button
                            type="submit"
                            class="btn btn-sm btn-dark w-100 mt-3"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="login">
                                Login
                            </span>
                            <span wire:loading wire:target="login">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Logging in...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        .form-check-input:checked {
            background-color: #000 !important;
            border-color: #000 !important;
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