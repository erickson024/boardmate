<div class="step5-tenant-description">
    <div class="row">

        <!-- Gender Selection -->
        <div class="col-12 mb-4">
            <label class="form-label fw-semibold mb-1">
                Tenant Gender <span class="text-danger">*</span>
            </label>
            <small class="text-muted d-block mb-2">Select your preferable gender for tenant.</small>

            <div x-data="{ selected: @entangle('gender').live }" class="row g-2">
                @foreach($genders as $key => $genderOption)
                    <div class="col-auto" wire:key="gender-{{ $key }}">
                        <button
                            type="button"
                            @click="selected === '{{ $key }}' ? selected = '' : selected = '{{ $key }}'"
                            class="d-flex flex-column align-items-center justify-content-center text-center border rounded-3 position-relative gender-box"
                            :class="selected === '{{ $key }}' 
                                ? 'bg-dark border-dark' 
                                : 'bg-white border-secondary'">

                            <!-- Checkmark -->
                            <i 
                                class="bi bi-check-circle-fill position-absolute top-0 end-0 m-1 rounded-circle text-light"
                                :class="selected === '{{ $key }}' ? 'd-inline-block' : 'd-none'"
                                style="font-size: 0.9rem;"></i>

                            <!-- Icon -->
                            <i class="{{ $genderOption['icon'] }} gender-icon"
                               :class="selected === '{{ $key }}' ? 'text-white' : 'text-dark'"></i>

                            <!-- Label -->
                            <span class="fw-medium gender-label"
                                  :class="selected === '{{ $key }}' ? 'text-white' : 'text-dark'">
                                {{ $genderOption['label'] }}
                            </span>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tenant Type Selection -->
        <div class="col-12">
            <label class="form-label fw-semibold mb-1">
                Tenant Type <span class="text-danger">*</span>
            </label>
            <small class="text-muted d-block mb-2">Select who can rent your property.</small>

            <div x-data="{ selected: @entangle('tenantType').live }" class="row g-2">
                @foreach($types as $key => $type)
                    <div class="col-3 col-md-2 mb-2" wire:key="tenant-type-{{ $key }}">
                        <button
                            type="button"
                            @click="selected === '{{ $key }}' ? selected = '' : selected = '{{ $key }}'"
                            class="d-flex flex-column align-items-center justify-content-center text-center border rounded-3 position-relative gender-box"
                            :class="selected === '{{ $key }}' 
                                ? 'bg-{{ $type['color'] }} shadow-lg' 
                                : 'bg-white {{ $type['color'] }} shadow-sm'">

                            <!-- Icon -->
                            <i class="{{ $type['icon'] }} gender-icon"
                               :class="selected === '{{ $key }}' ? 'text-white' : 'text-{{ $type['color'] }}'"></i>

                            <!-- Label -->
                            <span class="fw-medium gender-label"
                                  :class="selected === '{{ $key }}' ? 'text-light' : 'text-dark'">
                                {{ $type['label'] }}
                            </span>

                            <!-- Checkmark -->
                            <i class="bi bi-check-circle-fill position-absolute top-0 end-0 m-1 rounded-circle text-light"
                               :class="selected === '{{ $key }}' ? 'd-inline-block' : 'd-none'"
                               style="font-size: 0.9rem;"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    @error('gender')
        <div class="alert alert-danger d-flex align-items-center py-2 mt-2">
            <i class="bi bi-exclamation-circle me-2"></i>
            <small>{{ $message }}</small>
        </div>
    @enderror
</div>
