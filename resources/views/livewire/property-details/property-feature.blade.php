<div class="row vh-100 d-flex align-items-center feature-details">
    <div class="col-6 ">
        <!-- Header Section -->
        <div class="d-flex justify-content-start flex-row gap-2 mb-4">
            <div class="bg-dark d-flex align-items-center rounded text-light py-2 px-3">
                <i class="bi bi-building-check"></i>
            </div>
            <div class="text-start w-75">
                <p class="fw-medium fs-5 mb-0">What This Property Offers</p>
                <small class="text-muted mb-0">Explore the amenities and features that make this property stand out from the rest.</small>
            </div>
        </div>
    </div>
    <div class="col-6 ">
        <!-- Property Features Grid -->
        <div class="d-flex justify-content-end">
            <div class="w-100">
                <div class="d-flex flex-wrap gap-2 justify-content-end">

                    @if($property->propertyFeatures && is_array($property->propertyFeatures) && count($property->propertyFeatures) > 0)
                    @foreach($property->propertyFeatures as $index => $feature)
                    @php
                    $icon = $propertyFeatureIcons[$feature] ?? 'fas fa-check';
                    $colorClass = $featureColors[$feature] ?? 'bg-secondary';
                    $borderColorClass = str_replace('bg-', 'border-', $colorClass);
                    $textColorClass = str_replace('bg-', 'text-', $colorClass);
                    $delay = 0.1 + ($index * 0.1); // Stagger animation delay
                    @endphp

                    <div class="d-flex flex-column align-items-center justify-content-center text-center bg-white border {{ $borderColorClass }} rounded feature-box shadow-sm animate-float"
                        style="animation-delay: {{ $delay }}s;"
                        wire:key="property-feature-{{ $loop->index }}">
                        <!-- Icon -->
                        <i class="{{ $icon }} feature-icon {{ $textColorClass }}"></i>

                        <!-- Feature Label -->
                        <span class="fw-medium feature-label text-dark">
                            {{ $feature }}
                        </span>
                    </div>
                    @endforeach
                    @else
                    <div class="w-100">
                        <p class="text-muted text-end">No features available for this property.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>