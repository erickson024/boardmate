<div class="step1-basic-information"> <!--for css files-->
    <form wire:submit.prevent="submit">
        <div class="row gx-3 mb-3">
            <div class="col-6">
                <x-floating-labels.input
                    id="propertyName"
                    label="Property Name"
                    type="text"
                    wire:model="propertyName" 
                    required
                    />
            </div>

            <div class="col-6">
                <x-floating-labels.input
                    id="propertyCost"
                    label="Property Cost per Month"
                    type="number"
                    wire:model="propertyCost" 
                    required
                />
            </div>
        </div>

        <!-- Property Type Selection - Use Alphine JS to 0 delay-->
        <div
            x-data="{ selected: @entangle('propertyType').live }"
            class="row justify-content-start mb-3 gap-1">
            <small class="fw-medium mb-1 text-secondary">
                Select your property type.
            </small>

            @foreach($propertyTypes as $key => $label)
            <div class="col-3 col-md-2" wire:key="property-type-{{ $key }}">
                <button
                    type="button"
                    @click="selected = '{{ $key }}'"
                    :class="selected === '{{ $key }}'
                    ? 'bg-secondary text-white border-secondary shadow-lg'
                    : 'bg-white text-secondary border-secondary shadow-sm'"
                    class="d-flex flex-column align-items-center justify-content-center text-center border rounded feature-box">
                    <i
                        class="bi {{ $propertyTypeIcons[$key] ?? 'bi-building' }} feature-icon"
                        :class="selected === '{{ $key }}'
                        ? 'text-white'
                        : 'text-secondary'"></i>

                    <span class="fw-medium feature-label">
                        {{ $label }}
                    </span>
                </button>
            </div>
            @endforeach

            @error('propertyType')
                <div class="col-12 mt-2">
                    <span class="text-danger small">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <div class="row">
            <div class="col-12">
                <x-floating-labels.text-area
                    id="propertyDescription"
                    label="Property Description  (not required)"
                    height="200"
                    name="propertyDescription"
                    wire:model="propertyDescription" />
            </div>
        </div>

        <div class="mt-3">
            <button class="btn btn-sm btn-dark" type="submit">
                <span class="fw-medium">Continue</span>
                <span wire:loading wire:target="submit">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
            </button>
        </div>
    </form>

</div>