<div class="container-fluid">
    <div class="row w-100 justify-content-center mt-3">
        <div class="col-12 col-md-6">

            <div class="mb-3 d-flex justify-content-between">
                <button wire:click="goToHome" class="btn btn-dark fw-semibold btn-sm">
                    <i class="bi bi-arrow-left-short"></i>
                    <small>Boardmate Home</small>
                </button>

                <button class="btn btn-outline-dark fw-semibold btn-sm">
                    <small>Need Help?</small>
                </button>
            </div>

            <!-- Step Content -->
            <div class="mb-3">
                @if ($currentStep === 1)
                <livewire:properties.step1-basic-information />
                @elseif ($currentStep === 2)
                <livewire:properties.step2-address-map />
                @elseif ($currentStep === 3)
                <livewire:properties.step3-features />
                @elseif ($currentStep === 4)
                <livewire:properties.step4-restiction />
                @endif
            </div>

        </div>
    </div>


    <div class="position-fixed bottom-0 start-50 translate-middle-x w-100 bg-white p-2 shadow">
        <div class="d-flex justify-content-center gap-2">
            <div class="progress" style="height: 2px; width: 22%;">
                <div class="progress-bar {{ $currentStep >= 1 ? 'bg-dark' : 'bg-secondary' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 22%;">
                <div class="progress-bar {{ $currentStep >= 2 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 22%;">
                <div class="progress-bar {{ $currentStep >= 3 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 22%;">
                <div class="progress-bar {{ $currentStep >= 4 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 22%;">
                <div class="progress-bar {{ $currentStep >= 5 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
        </div>


        <div class="d-flex justify-content-between mt-4">

            @if ($currentStep > 1)
            <button
                class="btn btn-outline-dark btn-sm fw-semibold small"
                wire:click="prevStep"
                wire:loading.attr="disabled">
                <span>Back</span>
                <span wire:loading class="spinner-border spinner-border-sm" role="status"></span>
            </button>
            @else
            <span></span>
            @endif

            @if ($currentStep < 4)
                <button
                class="btn btn-dark btn-sm fw-semibold small"
                wire:click="$dispatch('validateCurrentStep')"
                wire:loading.attr="disabled">
                <span wire:loading.remove>Continue</span>
                <span wire:loading>
                    Saving
                    <span wire:loading class="spinner-border spinner-border-sm" role="status"></span>
                </span>
                </button>
                @else
                <button class="btn btn-success btn-sm">
                    Submit
                </button>
                @endif

        </div>


    </div>


</div>