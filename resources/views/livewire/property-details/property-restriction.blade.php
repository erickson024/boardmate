<div class="row vh-100 d-flex align-items-center section restriction-details">
    <div class="col-6">
        <!-- Header Section -->
        <div class="d-flex justify-content-start flex-row gap-2 mb-4">
            <div class="bg-danger d-flex align-items-center rounded text-light py-2 px-3">
                <i class="bi bi-shield-exclamation"></i>
            </div>
            <div class="text-start w-75">
                <p class="fw-medium fs-5 mb-0">Property Rules & Restrictions</p>
                <small class="text-muted mb-0">Important guidelines and rules you must follow while staying at this property.</small>
            </div>
        </div>
    </div>
    <div class="col-6">
        <!-- Property Restrictions Grid -->
        <div class="d-flex justify-content-start">
            <div class="w-100">
                <div class="d-flex flex-wrap gap-2 justify-content-start">

                    @if($property->propertyRestrictions && is_array($property->propertyRestrictions) && count($property->propertyRestrictions) > 0)
                    @foreach($property->propertyRestrictions as $index => $restriction)
                    @php
                    $icon = $propertyRestrictionIcons[$restriction] ?? 'fas fa-ban';
                    $delay = 0.1 + ($index * 0.1); // Stagger animation delay
                    @endphp

                    <div class="d-flex flex-column align-items-center justify-content-center text-center bg-white border border-danger rounded feature-box shadow-sm animate-float"
                        style="animation-delay: {{ $delay }}s;"
                        wire:key="property-restriction-{{ $loop->index }}">

                        <!-- Icon Wrapper with Badge -->
                        <div class="restriction-icon-wrapper position-relative mb-1">
                            <i class="{{ $icon }} restriction-icon"></i>
                            <!-- X Badge -->
                            <div class="restriction-badge">
                                <i class="fas fa-times restriction-badge-icon"></i>
                            </div>
                        </div>

                        <!-- Restriction Label -->
                        <span class="fw-medium feature-label text-dark">
                            {{ $restriction }}
                        </span>
                    </div>
                    @endforeach
                    @else
                    <div class="w-100">
                        <p class="text-muted text-start">No restrictions for this property.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>