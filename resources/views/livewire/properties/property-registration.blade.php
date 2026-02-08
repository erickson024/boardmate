<div class="property-registration">
    <div class="vh-100 overflow-auto">
        <div class="row w-100 justify-content-center mt-3">
            <div class="col-12 col-md-8 col-lg-6">
                <!-- Header with breadcrumb and actions -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button
                            class="btn btn-dark btn-sm d-flex align-items-center gap-2 fw-semibold"
                            data-bs-toggle="modal"
                            data-bs-target="#exitConfirmation">
                            <small>
                                <i class="bi bi-arrow-bar-left"></i>
                                <span class="d-none d-sm-inline">Properties</span>
                            </small>
                        </button>

                        <x-modal.backdrop id="exitConfirmation" title="Exit Registration?" class="modal-dialog-centered">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 text-center mb-3">
                                        <i class="bi bi-save text-dark fs-1"></i>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-center mb-4">
                                        <p class="fw-semibold fs-6 mb-2">What would you like to do?</p>
                                        @if($hasExistingData)
                                        <p class="text-muted small">You can save your progress and continue later, or delete the draft.</p>
                                        @else
                                        <p class="text-muted small">You haven't entered any data yet.</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <!-- Keep Draft (disabled if no data) -->
                                    <div class="col-6">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-dark fw-medium w-100"
                                            wire:click="keepDraftAndExit"
                                            data-bs-dismiss="modal"
                                            @if(!$hasExistingData) disabled @endif>
                                            <small>
                                                @if(!$hasExistingData)
                                                <span>No data to save</span>
                                                @else
                                                <i class="bi bi-save"></i>
                                                <span>Keep Draft & Exit</span>
                                                @endif
                                            </small>
                                        </button>
                                    </div>

                                    <!-- Delete/Exit -->
                                    <div class="col-6">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger fw-medium w-100"
                                            wire:click="deleteDraftAndExit"
                                            data-bs-dismiss="modal">
                                            <small>
                                                <span>{{ $hasExistingData ? 'Delete Draft &' : '' }} Exit</span>
                                            </small>
                                        </button>
                                    </div>

                                    <!-- Cancel -->
                                    <div class="col-12">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-dark fw-medium w-100"
                                            data-bs-dismiss="modal">
                                            <small>Cancel</small>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </x-modal.backdrop>


                        <button class="btn btn-outline-dark fw-semibold btn-sm d-flex align-items-center gap-2">
                            <small>
                                <span class="d-none d-sm-inline">Need Help</span>
                                <i class="bi bi-question-circle-fill"></i>
                            </small>
                        </button>
                    </div>
                </div>

                <!-- Step Content -->
                <div class="mb-5">
                    <div class="step-content">
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

                        <div class="{{ $currentStep !== 5 ? 'd-none' : '' }}" wire:key="step-5">
                            <livewire:properties.step5-tenant-description />
                        </div>

                        <div class="{{ $currentStep !== 6 ? 'd-none' : '' }}" wire:key="step-6">
                            <livewire:properties.step6-property-photo />
                        </div>

                        <div class="{{ $currentStep !== 7 ? 'd-none' : '' }}" wire:key="step-7">
                            <livewire:properties.step7-terms-condition />
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <!-- Fixed Bottom Navigation -->
        <div class="position-fixed bottom-0 start-0 w-100 bg-white border-top shadow-lg" style="z-index: 1030;">
            <div class="container">
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
                                    @elseif($currentStep === 5)
                                    <small><i class="bi bi-person me-1"></i> Tenant Description</small>
                                    @elseif($currentStep === 6)
                                    <small><i class="bi bi-camera me-1"></i> Property Photos</small>
                                    @else
                                    <small><i class="bi bi-file-text me-1"></i>Terms and Condition</small>
                                    @endif
                                </p>

                                <!--progress % indicator-->
                                <span class="fw-semibold text-muted small"><small>{{ round(($currentStep / $maxSteps) * 100) }}% Complete</small></span>
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
                                    <small>returning <span class="loading-dots"></span></small>
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
                                wire:loading.class="pe-none opacity-50"
                                wire:target="continueStep">
                                <span wire:loading.remove wire:target="continueStep">
                                    <small>continue
                                        <i class="bi bi-arrow-right"></i>
                                    </small>
                                </span>
                                <span wire:loading wire:target="continueStep">
                                    <small>saving<span class="loading-dots"></span></small>
                                </span>
                                </button>
                                @else
                                <button
                                    class="btn btn-sm btn-primary d-flex align-items-center gap-2 fw-semibold"
                                    wire:click="$dispatch('submitProperty')"
                                    wire:loading.attr="disabled"
                                    wire:target="submitProperty">
                                    <span wire:loading.remove wire:target="submitProperty">
                                        <i class="bi bi-check-circle"></i>
                                        <small>Submit Property</small>
                                    </span>
                                    <span wire:loading wire:target="submitProperty">
                                        <small>submitting<span class="loading-dots"></span></small>
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
        <div style="height: 50px;"></div>
    </div>
</div>