<div class="container-fluid">
    <div class="row w-100 justify-content-center mt-3">
        <div class="col-12 col-md-8 col-lg-6">
            <!-- Header with breadcrumb and actions -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button wire:click="goToHome" class="btn btn-dark btn-sm d-flex align-items-center gap-2 fw-semibold">
                        <small>
                            <i class="bi bi-arrow-bar-left"></i>
                            <span class="d-none d-sm-inline">Back to Home</span>
                            <span class="d-inline d-sm-none">Home</span>
                        </small>
                    </button>

                    <button class="btn btn-outline-primary btn-sm d-flex align-items-center gap-2">
                        <small>
                            <i class="bi bi-question-circle"></i>
                            <span class="d-none d-sm-inline">Need Help?</span>
                        </small>
                    </button>
                </div>
            </div>

            <!-- Step Content -->
            <div class="mb-5">
                <div class="step-content" style="min-height: 400px;">
                    <div class="{{ $currentStep !== 1 ? 'd-none' : '' }}" wire:key="step-1">
                        <livewire:properties.step1-basic-information />
                    </div>

                    <div class="{{ $currentStep !== 2 ? 'd-none' : '' }}" wire:key="step-2">
                        <livewire:properties.step2-address-map />
                    </div>

                    <div class="{{ $currentStep !== 3 ? 'd-none' : '' }}" wire:key="step-3">
                        <livewire:properties.step3-features />
                    </div>

                    <div class="{{ $currentStep !== 4 ? 'd-none' : '' }}" wire:key="step-4">
                        <livewire:properties.step4-restriction />
                    </div>

                    @if($currentStep === 5)
                    <div wire:key="step-5">
                        <!-- Step 5 content here -->
                        <p class="text-muted">Step 5 content</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Fixed Bottom Navigation -->
    <div class="position-fixed bottom-0 start-0 w-100 bg-white border-top shadow-lg" style="z-index: 1030;">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <!-- Progress Header -->

                    <div class=" py-2">
                        <div class="d-flex justify-content-between align-items-center ">
                            <!-- Step Titles -->
                            <p class="mb-2 text-muted small fw-semibold">
                                @if($currentStep === 1)
                                <small><i class="bi bi-info-circle me-1"></i> Basic Information</small>
                                @elseif($currentStep === 2)
                                <small><i class="bi bi-geo-alt me-1"></i> Property Location</small>
                                @elseif($currentStep === 3)
                                <small><i class="bi bi-star me-1"></i> Features & Amenities</small>
                                @elseif($currentStep === 4)
                                <small><i class="bi bi-shield-check me-1"></i> Rules & Restrictions</small>
                                @else
                                <small><i class="bi bi-camera me-1"></i> Photos & Final Details</small>
                                @endif
                            </p>

                            <span class="fw-semibold small"><small>{{ round(($currentStep / $maxSteps) * 100) }}% Complete</small></span>
                        </div>




                        <!-- Progress Bar -->
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-dark"
                                role="progressbar"
                                style="width: {{ ($currentStep / $maxSteps) * 100 }}%; transition: width 0.4s ease;"
                                aria-valuenow="{{ $currentStep }}"
                                aria-valuemin="0"
                                aria-valuemax="{{ $maxSteps }}">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-8 col-lg-12">
                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <!-- Back Button -->
                        @if ($currentStep > 1)
                        <button
                            class="btn btn-sm btn-outline-dark d-flex align-items-center gap-2 fw-semibold"
                            wire:click="prevStep"
                            wire:loading.attr="disabled"
                            wire:target="prevStep">
                            <small>
                                <i class="bi bi-arrow-left"></i>
                                <span wire:loading.remove wire:target="prevStep">previous</span>
                            </small>
                            <span wire:loading wire:target="prevStep">
                                <small>returning...</small>
                                <span class="spinner-border spinner-border-sm"></span>
                            </span>

                        </button>
                        @else
                        <div></div>
                        @endif

                        <!-- Step Counter (Mobile) -->
                        <div class="d-md-none text-muted small">
                            Step {{ $currentStep }} of {{ $maxSteps }}
                        </div>

                        <!-- Continue / Submit Button -->
                        @if ($currentStep < $maxSteps)
                            <button
                            class="btn btn-sm fw-semibold btn-dark d-flex align-items-center gap-2"
                            wire:click="continueStep"
                            wire:loading.attr="disabled"
                            wire:target="continueStep">
                            <span wire:loading.remove wire:target="continueStep">
                                <small>continue
                                    <i class="bi bi-arrow-right"></i>
                                </small>
                            </span>
                            <span wire:loading wire:target="continueStep">
                                <small>saving...</small>
                                <span class="spinner-border spinner-border-sm ms-2"></span>
                            </span>
                            </button>
                            @else
                            <button
                                class="btn btn-primary d-flex align-items-center gap-2 fw-semibold"
                                wire:click="submitProperty"
                                wire:loading.attr="disabled"
                                wire:target="submitProperty">
                                <span wire:loading.remove wire:target="submitProperty">
                                    <i class="bi bi-check-circle"></i>
                                    <small>Submit Property</small>
                                </span>
                                <span wire:loading wire:target="submitProperty">
                                    <small>submitting...</small>
                                    <span class="spinner-border spinner-border-sm ms-2"></span>
                                </span>
                            </button>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Spacer for fixed bottom navigation -->
    <div style="height: 80px;"></div>

    <style>
        /* Smooth step transitions */
        .step-content>div {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Step indicator line animation */
        .position-absolute {
            transition: background 0.3s ease;
        }

        /* Prevent layout shift */
        .step-content {
            transition: min-height 0.3s ease;
        }

        /* Better mobile spacing */
        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
</div>