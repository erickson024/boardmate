<div class="container" style="height: 85vh;">
    <div class="row gx-2 rounded h-100">

        <!--indicator-->
        <div class="col-lg-3 d-none d-lg-block py-2 slide-in-left ">
            <div class="bg-dark text-white rounded p-3 shadow h-100 d-flex flex-column justify-content-center align-items-start">
                <livewire:auth.indicator :currentStep="$currentStep" :totalSteps="3" />
            </div>
        </div>

        <!--multi step authentication-->
        <div class="col-lg-9 col-md-12 py-2 slide-in-up">
            <div class="bg-light p-3 p-md-4 p-lg-4  border border-dark rounded  h-100">

                <div class="row">
                    <div class="col-8 col-md-6 col-lg-6">
                        <p class="fw-semibold fs-4 mb-2">Create an account</p>
                        <p class="small">
                            Already have an account?
                            <a href="{{route('login')}}" class="link-underline-dark link-underline-opacity-0 link-underline-opacity-100-hover text-dark fw-medium">
                                Login</a>
                        </p>
                    </div>

                    <div class="col-4 col-sm-4 col-md-6 mb-2 d-flex justify-content-end">
                        <div class="gap-2">
                            <button class="btn btn-sm btn-dark"><i class="bi bi-google"></i></button>
                            <button class="btn btn-sm btn-dark"><i class="bi bi-hash"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Step Content -->
                @if ($currentStep === 1)
                @include('livewire.auth.steps.step-one')
                @elseif ($currentStep === 2)
                @include('livewire.auth.steps.step-two')
                @elseif ($currentStep === 3)
                @include('livewire.auth.steps.step-three')
                @endif

                <div class="row mt-2 g-2">
                    <div class="col-6 col-md-6 d-flex justify-content-start">
                        @if ($currentStep > 1)
                            <button wire:click="previousStep" class="btn btn-outline-secondary fade-in ">
                                Back
                                <span class="spinner-border spinner-border-sm" wire:loading wire:target="previousStep"></span>
                            </button>
                        @else
                           
                        @endif
                    </div>
                    <div class="col-6 col-md-6 d-flex justify-content-end ">
                        @if ($currentStep < 3)
                            <button wire:click="nextStep" class="btn btn-dark">
                                Continue
                                <span class="spinner-border spinner-border-sm" wire:loading wire:target="nextStep"></span>
                            </button>
                        @else
                            <button wire:click="submit"
                                class="btn btn-dark"
                                wire:loading.attr="disabled"
                                wire:target="submit">
                                <span>Register</span>
                                <span class="spinner-border spinner-border-sm"
                                    role="status"
                                    aria-hidden="true"
                                    wire:loading
                                    wire:target="submit"></span>
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>