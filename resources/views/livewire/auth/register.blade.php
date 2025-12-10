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
                        <x-buttons.small-button href="{{route('login')}}" class="fw-semibold">
                            Log In
                        </x-buttons.small-button>
                    </div>
                </div>
                <div class="fs-5 fw-semibold my-2">Create an account</div>
                
                <!--register forms-->
                <form wire:submit.prevent="register">
                    <div class="row gx-4">

                        <div class="col-6">
                            <x-inputs.floating-input
                                id="firstName"
                                label="First Name"
                                model="firstName" />
                        </div>

                        <div class="col-6">
                            <x-inputs.floating-input
                                id="lastName"
                                label="Last Name"
                                model="lastName" />
                        </div>

                        <div class="col-12">
                            <x-inputs.floating-input
                                id="email"
                                label="Email Address"
                                type="email"
                                model="email" />
                        </div>
                    </div>

                    <div class="row mt-1">
                        <small class="mb-2">Tip: Add uppercase letters, numbers, or symbols for a stronger password.</small>
                        <div class="col-12">
                            <div class="progress rounded mb-2" style="height: 3px;">
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
                                label="Create Password"
                                type="password"
                                model="password" />
                        </div>

                        <div class="col-12">
                            <x-inputs.floating-input
                                id="confirmPassword"
                                label="Confirm Password"
                                type="password"
                                model="passwordConfirmation" />
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input shadow-none border-dark"
                                    wire:model="terms">
                                <label>
                                    <small>I agree to the
                                        <a href=""
                                            class="link-dark link-offset-2 link-offset-1-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover text-dark fw-medium">terms and conditions</a>.</small>
                                </label>
                            </div>
                            @error('terms')
                            <small class="text-danger ms-1">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="my-3">
                        <x-buttons.small-button action="register" class="w-25 fw-semibold">
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