<div class="container-fluid p-0">
    <!-- Header -->
    <div class="bg-white border-bottom">
        <div class="container">
            <div class="row px-4 py-3">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('property-list') }}" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-arrow-left me-2"></i>
                                <small>Back to Properties</small>
                            </a>
                            <h5 class="mb-0 fw-semibold mt-2">Property Details</h5>
                        </div>
                        <div>
                            @if($isEditing)
                                <button wire:click="toggleEdit" class="btn btn-sm btn-outline-secondary rounded-3 me-2">
                                    <i class="fa-solid fa-times me-1"></i>
                                    <small>Cancel</small>
                                </button>
                                <button wire:click="update" class="btn btn-sm btn-success rounded-3">
                                    <i class="fa-solid fa-save me-1"></i>
                                    <small>Save Changes</small>
                                </button>
                            @else
                                <button wire:click="toggleEdit" class="btn btn-sm btn-dark rounded-3">
                                    <i class="fa-solid fa-edit me-1"></i>
                                    <small>Edit Property</small>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session()->has('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Content -->
    <div class="container p-4">
        <div class="row">
            <!-- Images Section -->
            <div class="col-12 col-lg-7 mb-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-3">Property Images</h6>
                        
                        <!-- Existing Images -->
                        <div class="row g-3 mb-3">
                            @forelse($images as $index => $image)
                                <div class="col-6 col-md-4">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $image) }}" 
                                             alt="Property Image" 
                                             class="img-fluid rounded-3 w-100" 
                                             style="height: 150px; object-fit: cover;">
                                        @if($isEditing)
                                            <button wire:click="removeExistingImage({{ $index }})" 
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle p-0" 
                                                    style="width: 30px; height: 30px;">
                                                <i class="fa-solid fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="text-center py-4 bg-light rounded-3">
                                        <i class="fa-solid fa-image fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0"><small>No images uploaded</small></p>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- New Images Preview -->
                        @if($isEditing && count($newImages) > 0)
                            <h6 class="fw-semibold mb-3 mt-4">New Images</h6>
                            <div class="row g-3 mb-3">
                                @foreach($newImages as $index => $image)
                                    <div class="col-6 col-md-4">
                                        <div class="position-relative">
                                            <img src="{{ $image->temporaryUrl() }}" 
                                                 alt="New Image" 
                                                 class="img-fluid rounded-3 w-100" 
                                                 style="height: 150px; object-fit: cover;">
                                            <button wire:click="removeNewImage({{ $index }})" 
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle p-0" 
                                                    style="width: 30px; height: 30px;">
                                                <i class="fa-solid fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Upload New Images -->
                        @if($isEditing)
                            <div class="mt-3">
                                <label class="form-label fw-semibold"><small>Add More Images</small></label>
                                <input type="file" wire:model="newImages" multiple accept="image/*" class="form-control">
                                @error('newImages.*') 
                                    <span class="text-danger small">{{ $message }}</span> 
                                @enderror
                                <small class="text-muted">Maximum 2MB per image</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Details Section -->
            <div class="col-12 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-3">Property Information</h6>
                        
                        @if($isEditing)
                            <!-- Edit Form -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold"><small>Property Name</small></label>
                                <input type="text" wire:model="propertyName" class="form-control" placeholder="Enter property name">
                                @error('propertyName') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold"><small>Property Type</small></label>
                                <select wire:model="propertyType" class="form-select">
                                    <option value="">Select Type</option>
                                    <option value="Apartment">Apartment</option>
                                    <option value="House">House</option>
                                    <option value="Condo">Condo</option>
                                    <option value="Room">Room</option>
                                    <option value="Bedspace">Bedspace</option>
                                </select>
                                @error('propertyType') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold"><small>Address</small></label>
                                <textarea wire:model="address" class="form-control" rows="2" placeholder="Enter complete address"></textarea>
                                @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold"><small>Monthly Cost (₱)</small></label>
                                <input type="number" wire:model="propertyCost" class="form-control" placeholder="0.00" step="0.01">
                                @error('propertyCost') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold"><small>Tenant Type</small></label>
                                <select wire:model="tenantType" class="form-select">
                                    <option value="">Select Type</option>
                                    <option value="Student">Student</option>
                                    <option value="Professional">Professional</option>
                                    <option value="Family">Family</option>
                                    <option value="Any">Any</option>
                                </select>
                                @error('tenantType') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold"><small>Tenant Gender</small></label>
                                <select wire:model="tenantGender" class="form-select">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male Only</option>
                                    <option value="Female">Female Only</option>
                                    <option value="Any">Any</option>
                                </select>
                                @error('tenantGender') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold"><small>Status</small></label>
                                <select wire:model="status" class="form-select">
                                    <option value="draft">Draft</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold"><small>Description</small></label>
                                <textarea wire:model="description" class="form-control" rows="3" placeholder="Enter property description"></textarea>
                                @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        @else
                            <!-- View Mode -->
                            <div class="mb-3">
                                <small class="text-muted d-block">Property Name</small>
                                <p class="mb-0 fw-semibold">{{ $propertyName }}</p>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Property Type</small>
                                <span class="badge bg-dark">{{ $propertyType }}</span>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Address</small>
                                <p class="mb-0"><small>{{ $address }}</small></p>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Monthly Cost</small>
                                <p class="mb-0 fw-semibold text-success">₱{{ number_format($propertyCost, 2) }}</p>
                            </div>

                            @if($tenantType)
                            <div class="mb-3">
                                <small class="text-muted d-block">Tenant Type</small>
                                <p class="mb-0">{{ $tenantType }}</p>
                            </div>
                            @endif

                            @if($tenantGender)
                            <div class="mb-3">
                                <small class="text-muted d-block">Tenant Gender</small>
                                <p class="mb-0">{{ $tenantGender }}</p>
                            </div>
                            @endif

                            <div class="mb-3">
                                <small class="text-muted d-block">Status</small>
                                <span class="badge {{ $status === 'active' ? 'bg-success' : ($status === 'inactive' ? 'bg-secondary' : 'bg-warning') }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </div>

                            @if($description)
                            <div class="mb-3">
                                <small class="text-muted d-block">Description</small>
                                <p class="mb-0"><small>{{ $description }}</small></p>
                            </div>
                            @endif

                            <div class="mb-3">
                                <small class="text-muted d-block">Listed</small>
                                <p class="mb-0"><small>{{ $property->created_at->format('M d, Y') }} ({{ $property->created_at->diffForHumans() }})</small></p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Danger Zone -->
                @if(!$isEditing)
                <div class="card border-danger border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold text-danger mb-3">Danger Zone</h6>
                        <p class="text-muted mb-3"><small>Once you delete a property, there is no going back. Please be certain.</small></p>
                        <button 
                            wire:click="deleteProperty" 
                            wire:confirm="Are you sure you want to delete this property? This action cannot be undone."
                            class="btn btn-sm btn-danger rounded-3 w-100">
                            <i class="fa-solid fa-trash me-1"></i>
                            <small>Delete Property</small>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>