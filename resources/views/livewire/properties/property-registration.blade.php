<div>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center mt-3">
            
            <!-- Back Button -->
            <div class="container-fluid">
                <div class="row d-flex justify-content-center mb-3">
                    <div class="col-6">
                        <x-buttons.small-button href="{{route('home')}}" class="fw-semibold">
                            <i class="bi bi-arrow-left-short"></i>
                            <span class="fw-semibold small">Boardmate</span>
                        </x-buttons.small-button>
                    </div>
                </div>
            </div>
            <!--step2 map address-->
            <div id="map-container" class="{{ $currentStep === 2 ? '' : 'd-none' }}">
                <div class="row gap-2  d-flex justify-content-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <p class="fs-6 fw-semibold text-start mb-0">Enter the full address of the property so tenants can locate it easily.</p>
                        <small class="mt-0">You may drag the Pegman to save the exact location of your property.</small>
                    </div>

                    <div class="col-12 col-md-6 col-lg-6 position-relative mt-3">
                        <!-- Map -->
                        <div
                            wire:ignore
                            id="map"
                            data-lat="{{ $latitude ?? 14.5547 }}"
                            data-lng="{{ $longitude ?? 121.0244 }}"
                            data-address="{{ $address ?? '' }}"
                            class="rounded"
                            style="height: 330px; width: 100%;">
                        </div>

                        <!-- Input on top of map -->
                        <div wire:key="field-address"
                            class="position-absolute top-0 start-50 translate-middle-x w-75 px-2"
                            style="z-index: 10; margin-top: 10px;">
                            <div
                                class="input-group shadow"
                                aria-label="Property address"
                                autocomplete="street-address">
                                <span class="input-group-text bg-light-subtle text-white border-0 px-3">
                                    <i class="bi bi-geo-alt-fill text-dark"></i>
                                </span>
                                <input
                                    type="text"
                                    class="form-control text-dark shadow-none fw-semibold border-0 p-3 "
                                    placeholder="Enter your address"
                                    id="address-input"
                                    wire:model="address"
                                    style="font-size: 13px;"
                                    autocomplete="off"
                                    aria-describedby="basic-addon1"
                                    required>
                            </div>
                        </div>
                        @error('address')
                        <small class="text-danger d-block mt-1 bg-white p-2 rounded" style="font-size: 13px;">{{ $message }}</small>
                        @enderror
                        <input type="hidden" id="latitude" wire:model="latitude">
                        <input type="hidden" id="longitude" wire:model="longitude">
                    </div>
                </div>

                <script
                    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps.key') }}&libraries=places&callback=initMap"
                    async
                    defer>
                </script>
            </div>

            <div class="col-12 col-md-6 col-lg-6 d-flex justify-content-start">
                @if ($currentStep === 1)
                <livewire:properties.step1 />
                @elseif ($currentStep === 2)
                <livewire:properties.step2 />
                @elseif ($currentStep === 3)
                <livewire:properties.step3 />
                @elseif ($currentStep === 4)
                <livewire:properties.step4 />
                @elseif ($currentStep === 5)
                <livewire:properties.step5 />
                @else
                <livewire:properties.step6 />
                @endif
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
</div>