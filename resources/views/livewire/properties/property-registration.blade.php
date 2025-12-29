<div class="container-fluid flex-grow-1 d-flex align-items-center justify-content-center">
    <div class="row w-100 justify-content-center mt-3">
        <div class="col-12 col-md-6">
            <div>
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
                    <livewire:auth.signup.step3 />
                    @elseif ($currentStep === 4)
                    <livewire:auth.signup.step4 />
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="position-fixed bottom-0 start-50 translate-middle-x w-100 bg-white p-2">
        <div class="d-flex justify-content-center gap-2">
            <div class="progress" style="height: 2px; width: 16%;">
                <div class="progress-bar {{ $currentStep >= 1 ? 'bg-dark' : 'bg-secondary' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 16%;">
                <div class="progress-bar {{ $currentStep >= 2 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 16%;">
                <div class="progress-bar {{ $currentStep >= 3 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 16%;">
                <div class="progress-bar {{ $currentStep >= 4 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 16%;">
                <div class="progress-bar {{ $currentStep >= 5 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="progress" style="height: 2px; width: 16%;">
                <div class="progress-bar {{ $currentStep >= 6 ? 'bg-dark' : 'bg-secondary-subtle' }}" role="progressbar" style="width: 100%"></div>
            </div>
        </div>
    </div>
</div>