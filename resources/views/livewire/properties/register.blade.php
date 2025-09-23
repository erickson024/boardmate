<div class="container-fluid">
    <div class="row p-2 gx-3 rounded" >
         <!--debug-->
     
        <!--indicator-->
        <div class="col-3 slide-in-left">
            <div class="bg-dark text-white rounded p-3 shadow h-100 d-flex flex-column justify-content-center align-items-start">
                <livewire:properties.indicator :currentStep="$currentStep" :totalSteps="4" />
            </div>
        </div>

        <div class="col-9 slide-in-up">
            <div class="bg-light p-4 shadow rounded " style="height: 470px;">
                <div class="row">
                    <div class="col-6">
                        <p class="fw-semibold fs-5 mb-4">Add Your Property</p>

                    </div>

                    <div class="col-6 d-flex justify-content-end">
                        <div class="gap-2">
                            <button class="btn btn-sm btn-dark"><i class="bi bi-google"></i></button>
                            <button class="btn btn-sm btn-dark"><i class="bi bi-hash"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Step Content -->
                @if ($currentStep === 1)
                @include('livewire.properties.steps.step-one')
                @elseif ($currentStep === 2)
                @include('livewire.properties.steps.step-two')
                @elseif ($currentStep === 3)
                @include('livewire.properties.steps.step-three')
                @elseif ($currentStep === 4)
                @include('livewire.properties.steps.step-four')
                @endif

                <div class="mt-2 d-flex justify-content-between">
                    @if ($currentStep > 1)
                    <button wire:click="previousStep" class="btn btn-outline-secondary fade-in">Back
                        <span class="spinner-border spinner-border-sm" wire:loading wire:target="previousStep"></span>
                    </button>

                    @else
                    <div></div>
                    @endif

                    @if ($currentStep < 4)
                        <button wire:click="nextStep" class="btn btn-dark">Continue
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