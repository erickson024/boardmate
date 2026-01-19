<div class="property-filter sticky-top bg-white" style="z-index: 1000;">
    <div class="container py-3">

        {{-- Airbnb-style Search Bar --}}
        <div class="search-bar-wrapper mx-auto" style="max-width: 850px;">
            <div class="search-bar shadow-sm">
                <div class="row g-0 align-items-center">
                    {{-- Location --}}
                    <div class="col-3 col-md-3">
                        <div class="search-item search-item-first">
                            <label class="search-label">Location</label>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="address"
                                class="search-input"
                                placeholder="Where to?">
                        </div>
                    </div>

                    {{-- Property Name --}}
                    <div class="col-3 col-md-3">
                        <div class="search-item">
                            <label class="search-label">Property</label>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="propertyName"
                                class="search-input"
                                placeholder="Search properties">
                        </div>
                    </div>

                    {{-- Budget --}}
                    <div class="col-3 col-md-2">
                        <div class="search-item">
                            <label class="search-label">Budget</label>
                            <input
                                type="number"
                                wire:model.live.debounce.300ms="maxCost"
                                class="search-input"
                                placeholder="Max cost"
                                min="0"
                                step="100">
                        </div>
                    </div>

                    {{-- Filters Toggle --}}
                    <div class="col-3 col-md-2">
                        <div class="search-item">
                            <button
                                type="button"
                                class="btn-filters w-100"
                                data-bs-toggle="collapse"
                                data-bs-target="#filterCollapse">
                                <i class="bi bi-sliders"></i>
                                <span class="ms-2">Filters</span>
                                @if($propertyType || $tenantType || $tenantGender)
                                <span class="badge bg-danger rounded-circle ms-1" style="font-size: 10px; padding: 2px 6px;">
                                    {{ collect([$propertyType, $tenantType, $tenantGender])->filter()->count() }}
                                </span>
                                @endif
                            </button>
                        </div>
                    </div>

                    {{-- Search/Clear Button --}}
                    <div class="col-12 col-md-2">
                        <div class="search-item search-item-last d-flex align-items-center justify-content-end">
                            @if($propertyName || $propertyType || $tenantType || $tenantGender || $maxCost || $address)
                            <button
                                type="button"
                                wire:click="clearFilters"
                                class="btn-clear me-2">
                                <i class="bi bi-x-circle"></i>
                            </button>
                            @endif
                            <button type="button" class="btn-search">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Collapsible Filters --}}
            <div class="collapse mt-3" id="filterCollapse">
                <div class="filters-panel">
                    <div class="row g-3">
                        {{-- Property Type --}}
                        <div class="col-4 col-md-4">
                            <label class="filter-panel-label">Property Type</label>
                            <select wire:model.live="propertyType" class="form-select form-select-sm">
                                <option value="">All Types</option>
                                @foreach($propertyTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tenant Type --}}
                        <div class="col-4 col-md-4">
                            <label class="filter-panel-label">For</label>
                            <select wire:model.live="tenantType" class="form-select form-select-sm">
                                <option value="">All Tenants</option>
                                @foreach($tenantTypes as $type)
                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Gender --}}
                        <div class="col-4 col-md-4">
                            <label class="filter-panel-label">Gender</label>
                            <select wire:model.live="tenantGender" class="form-select form-select-sm">
                                <option value="">All Genders</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>