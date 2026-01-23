<div class="container-fluid p-0 property-list vh-100 overflow-auto">
    <!-- Include the search filter -->
    <div class="bg-white">
        <div class="container">
             @livewire('property-filter')
        </div>
    </div>

    <div class="container-fluid p-4 mb-4">

        @if($properties->count() > 0)
        <div class="row">
            @foreach($properties as $property)
            <div class="col-12 col-md-4 mb-4">
                <a href="{{ route('host-property-details', $property->id) }}" class="text-decoration-none">
                    <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden property-card" style="transition: all 0.3s ease; cursor: pointer;">
                        <!-- Property Image -->
                        <div class="position-relative" style="height: 200px; overflow: hidden;">
                            @if($property->images && count($property->images) > 0)
                            <img
                                src="{{ asset('storage/' . $property->images[0]) }}"
                                alt="{{ $property->propertyName }}"
                                class="w-100 h-100 object-fit-cover">
                            @else
                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-house fa-3x text-muted"></i>
                            </div>
                            @endif

                            <!-- Status Badge -->
                            <span class="badge position-absolute top-0 end-0 m-3 {{ $property->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($property->status ?? 'draft') }}
                            </span>

                            <!-- Property Type Badge -->
                            @if($property->propertyType)
                            <span class="badge position-absolute top-0 start-0 m-3 bg-dark bg-opacity-75">
                                {{ $property->propertyType }}
                            </span>
                            @endif
                        </div>

                        <!-- Property Details -->
                        <div class="card-body">
                            <h6 class="card-title fw-semibold mb-2 text-truncate text-dark">{{ $property->propertyName }}</h6>
                            <p class="text-muted small mb-2">
                                <i class="fa-solid fa-location-dot me-1"></i>
                                <small>{{ $property->address }}</small>
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer bg-light border-0">
                            <small class="text-muted">
                                <i class="fa-solid fa-clock me-1"></i>
                                Listed {{ $property->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                {{ $properties->links() }}
            </div>
        </div>

        @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fa-solid fa-house-circle-xmark fa-2x text-muted mb-3"></i>
                        <h5 class="mb-2"><small>No Properties Found</small></h5>
                        <p class="text-muted mb-4">
                            @if($propertyName || $location || $propertyType || $tenantType || $tenantGender || $propertyCost)
                            No properties match your current filters.
                            @else
                            You haven't registered any properties yet.
                            @endif
                        </p>
                        @if($propertyName || $location || $propertyType || $tenantType || $tenantGender || $propertyCost)
                        <p class="text-muted small">Try adjusting your filters or</p>
                        @endif
                        <a href="{{route('property-registration')}}" class="btn btn-sm btn-dark rounded-3">
                            <i class="fa-solid fa-plus me-2"></i>
                           <small>{{ $propertyName || $location || $propertyType || $tenantType || $tenantGender || $propertyCost ? 'Add New Property' : 'Register Your First Property' }}</small> 
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <style>
        .property-list .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .property-list .object-fit-cover {
            object-fit: cover;
        }
    </style>
</div>