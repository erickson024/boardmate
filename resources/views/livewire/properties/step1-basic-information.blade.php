<div class="step1-basic-information">

    <div class="col-12 mb-2">
        <p class="fs-6 fw-semibold text-start mb-1">Basic Information</p>
        <small class="text-muted">
            Provide the essential details of your property, including its name, type, and pricing.
            This information helps tenants quickly understand what your property offers.
        </small>
    </div>

    <div class="row gx-3 mb-3">
        <div class="col-6">
            <x-floating-labels.input
                id="propertyName"
                label="Property Name"
                type="text"
                wire:model.blur="propertyName"
                required />
        </div>

        <div class="col-6">
            <x-floating-labels.input
                id="propertyCost"
                label="Property Cost per Month"
                type="number"
                wire:model.blur="propertyCost"
                required />
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-10">
            <p class="fw-medium mb-1"><small>Select your property type</small></p>

            <!-- Alpine for instant UI + Livewire sync -->
            <div x-data="{ 
                selected: $wire.entangle('propertyType').live 
            }" class="row g-3 mb-2">
                @foreach(self::PROPERTY_TYPES as $key => $label)
                <div class="col-auto" wire:key="property-type-{{ $key }}">
                    <button
                        type="button"
                        @click="selected = (selected === '{{ $key }}') ? '' : '{{ $key }}'"
                        :class="selected === '{{ $key }}'
                            ? 'bg-secondary text-white border-secondary shadow-lg'
                            : 'bg-white text-secondary border-secondary shadow-sm'"
                        class="d-flex flex-column align-items-center justify-content-center text-center border rounded feature-box">

                        <i :class="selected === '{{ $key }}' ? 'text-white' : 'text-secondary'"
                            class="bi {{ self::PROPERTY_TYPE_ICONS[$key] ?? 'bi-building' }} feature-icon"></i>

                        <span class="fw-medium feature-label">
                            {{ $label }}
                        </span>
                    </button>
                </div>
                @endforeach
            </div>

            @error('propertyType')
            <div class="alert alert-danger d-flex align-items-center">
                <small>
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ $message }}
                </small>
            </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <x-floating-labels.text-area
                id="propertyDescription"
                label="Property Description"
                height="200"
                name="propertyDescription"
                wire:model.blur="propertyDescription" />
        </div>
    </div>
</div>