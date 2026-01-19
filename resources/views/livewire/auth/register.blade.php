<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Left: Form -->
        <div class="col-12 col-md-6 col-lg-6 ">
            <div class="w-100 px-4 px-md-5">
                <div class="col-12 d-flex justify-content-between my-4">
                    <div>
                        <x-buttons.small-button href="{{route('welcome')}}" class="fw-semibold">
                            <i class="bi bi-arrow-left-short"></i>
                            Boardmate
                        </x-buttons.small-button>
                    </div>
                    <div>
                        <x-buttons.small-button variant="btn btn-outline-dark" href="{{route('login')}}" class="fw-semibold">
                            Already have an Account? Log In
                        </x-buttons.small-button>
                    </div>
                </div>

                <div class="fs-5 fw-semibold my-2">Create an account</div>

                <!--register forms-->
                <form wire:submit.prevent="register">
                    <!-- name field -->
                    <div class="row mb-3 gx-4">

                        <div class="col-6">
                            <x-floating-labels.input
                                id="firstName"
                                label="First Name"
                                type="text"
                                wire:model="firstName"
                                required />
                        </div>

                        <div class="col-6">
                            <x-floating-labels.input
                                id="lastName"
                                label="Last Name"
                                type="text"
                                wire:model="lastName"
                                required />
                        </div>
                    </div>

                    <!-- email field -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <x-floating-labels.input
                                id="email"
                                label="Email Address"
                                type="email"
                                wire:model="email"
                                required />
                        </div>
                    </div>

                    <!-- password field -->
                    <div class="row mt-1 mb-3">
                        <small class="mb-2 text-secondary fw-light">Tip: Add uppercase letters, numbers, or symbols for a stronger password.</small>

                        <div class="col-12">
                            <x-indicators.password-strength :strength-score="$strengthScore" />
                        </div>

                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <x-floating-labels.input
                                id="password"
                                label="Set Password"
                                type="password"
                                wire:model.live="password"
                                required />

                        </div>

                        <div class="col-12 col-md-6">
                            <x-floating-labels.input
                                id="passwordConfirmation"
                                label="Confirm Password"
                                type="password"
                                wire:model="passwordConfirmation"
                                required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input shadow-sm border-secondary"
                                    wire:model="terms">
                                <label>
                                    <small>
                                        <span class="fw-medium text-secondary">I agree to the</span>
                                        <a href=""
                                            class="link-dark link-offset-2 link-offset-1-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover text-dark fw-semibold"
                                            data-bs-toggle="modal"
                                            data-bs-target="#terms">
                                            terms and conditions</a>

                                        <x-modal.backdrop id="terms"  title="Terms and Condition">
                                            <x-slot name="header">
                                               
                                            </x-slot>

                                            <x-terms-condition />

                                            <x-slot name="footer">
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-dark"
                                                    wire:click="$set('terms', true)"
                                                    data-bs-dismiss="modal">
                                                    <small>I Agree</small>
                                                </button>
                                            </x-slot>
                                        </x-modal.backdrop>
                                    </small>
                                </label>
                            </div>
                            @error('terms')
                            <small class="text-danger ms-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <div class="my-3">
                        <x-buttons.small-button
                            type="submit"
                            action="register"
                            class="w-25 fw-semibold">
                            Register
                        </x-buttons.small-button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Image (hidden on small screens) -->
        <div class="col-12 col-md-6 col-lg-6 d-flex flex-column bg-dark">
            <div class="flex-column text-center py-4">
                <img
                    src="{{ asset('images/logo-light.png') }}"
                    style="width: 10%;"
                    alt="Logo">
                <div class="fs-4 fw-semibold text-light ">JOIN OUR COMMUNITY</div>
                <div class="fs-6 fw-medium text-light ">connect with tenant and host</div>
                <!-- This empty div pushes the image down -->
                <div class="flex-grow-1"></div>
            </div>

            <div class="mt-auto position-relative">
                <img
                    src="{{ asset('images/image4.png') }}"
                    alt="Sign up hero image"
                    class="img-fluid w-100"
                    style="object-fit: cover; object-position: center; max-height: 85vh; flex-shrink: 0;"
                    loading="lazy" />
            </div>
        </div>

    </div>
</div>