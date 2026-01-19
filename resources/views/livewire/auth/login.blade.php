<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Left: Form -->
        <div class="col-12 col-md-6 col-lg-6 ">
            <div class="w-100 px-4 px-md-5 mb-3 mb-md-0">
                <div class="col-12 d-flex justify-content-between my-4">
                    <div>
                        <x-buttons.small-button href="{{route('welcome')}}" class="fw-semibold">
                            <i class="bi bi-arrow-left-short"></i>
                            Boardmate
                        </x-buttons.small-button>
                    </div>
                    <div>
                        <x-buttons.small-button href="{{route('register')}}" variant="btn btn-outline-dark" class="fw-semibold">
                            Create an account
                        </x-buttons.small-button>
                    </div>
                </div>
                <div class="fs-5 fw-semibold my-2">Sign In your account</div>

                <!--login forms-->
                <form action="" wire:submit.prevent="login">
                    <div class="col-12 mb-3">
                        <x-floating-labels.input
                            id="email"
                            label="Email Address"
                            type="email"
                            wire:model="email"
                            wire:loading.attr="disabled"
                            wire:target="login" 
                            required/>
                    </div>

                    <div class="col-12 mb-3">
                        <x-floating-labels.input
                            id="password"
                            label="Enter Password"
                            type="password"
                            wire:model="password"
                            wire:loading.attr="disabled"
                            wire:target="login" 
                            required/>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6 d-flex justify-content-start">
                            <div class="form-check">
                                <input
                                    class="form-check-input shadow-sm border-secondary"
                                    type="checkbox"
                                    value=""
                                    id="checkDefault"
                                    wire:model="remember"
                                    wire:loading.attr="disabled"
                                    wire:target="login">
                                <label class="form-check-label fw-medium text-secondary" for="checkDefault">
                                    <small>Remember me</small>
                                </label>
                            </div>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <a href="{{route('password.request')}}" class="link-underline-secondary link-underline-opacity-0 link-underline-opacity-100-hover text-secondary fw-medium"
                                wire:loading.attr="disabled"
                                wire:target="login"
                                wire:navigate>
                                <small>Forgot your Password?</small>
                            </a>
                        </div>
                    </div>

                    <x-buttons.small-button
                        type="submit"
                        action="login"
                        class="w-25 fw-semibold"
                        wire:loading.attr="disabled"
                        wire:target="login">
                        Log In
                    </x-buttons.small-button>
                </form>
            </div>
        </div>

        <!-- Right: Image (hidden on small screens) -->
        <div class="col-12 col-md-6 col-lg-6 d-flex flex-column   bg-dark">
            <div class="flex-column text-center py-4">
                <img
                    src="{{ asset('images/logo-light.png') }}"
                    style="width: 10%;"
                    alt="Logo">
                <div class="fs-4 fw-semibold text-light ">Access Your Account</div>
                <div class="fs-6 fw-medium text-light ">sign in and continue</div>
                <!-- This empty div pushes the image down -->
                <div class="flex-grow-1"></div>
            </div>

            <div class="mt-auto position-relative">
                <img
                    src="{{ asset('images/image6.png') }}"
                    alt="Sign up hero image"
                    class="img-fluid w-100"
                    style="object-fit: cover; object-position: center; max-height: 85vh; flex-shrink: 0;"
                    loading="lazy" />
            </div>
        </div>

    </div>
</div>
