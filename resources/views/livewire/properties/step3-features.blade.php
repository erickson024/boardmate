<div class="row step3-features">
    <div class="col-12 mb-2">
        <p class="fs-6 fw-semibold text-start mb-1">Property Features</p>
        <small class="text-muted">
            Select the features available in your property. Click on each feature to include it in your listing.
        </small>
    </div>

    <div class="col-12">
        <div x-data="{ selected: @entangle('propertyFeatures') }" class="row justify-content-start mb-3">

            @foreach($propertyFeatureIcons as $key => $icon)
                @php
                    $colorClass = $featureColors[$key] ?? 'bg-secondary';
                    $borderColorClass = str_replace('bg-', 'border-', $colorClass);
                @endphp

                <div class="col-3 col-md-2 gap-4 mb-2" wire:key="property-feature-{{ $key }}">
                    <button
                        type="button"
                        @click="
                            if(selected.includes('{{ $key }}')){
                                selected = selected.filter(f => f !== '{{ $key }}')
                            } else {
                                selected.push('{{ $key }}')
                            }"
                        :class="selected.includes('{{ $key }}')
                            ? '{{ $colorClass }} text-white {{ $borderColorClass }} shadow-lg'
                            : 'bg-white text-dark {{ $borderColorClass }} shadow-sm'"
                        class="d-flex flex-column align-items-center justify-content-center text-center border rounded feature-box"
                    >
                        <!-- Icon always dark unless selected -->
                        <i class="{{ $icon }} feature-icon"
                           :class="selected.includes('{{ $key }}') ? 'text-white' : 'text-{{ str_replace('bg-', '', $colorClass) }}'"></i>

                        <!-- Feature Label always dark unless selected -->
                        <span class="fw-medium feature-label"
                              :class="selected.includes('{{ $key }}') ? 'text-white' : 'text-dark'">
                            {{ $key }}
                        </span>
                    </button>
                </div>
            @endforeach

            @error('propertyFeatures')
            <div class="col-12 mt-2">
                <span class="text-danger small">{{ $message }}</span>
            </div>
            @enderror

        </div>
    </div>
</div>
