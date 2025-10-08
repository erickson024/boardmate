<div>
    <div class="row g-2 bg-white bg-opacity-75 p-2 sticky-top justify-content-center">
        <div class="input-group bg-white shadow rounded-4 justify-content-center w-75">
            <div class="form-floating ">
                <input
                    class="form-control form-control-sm rounded-4"
                    style="outline: none;  box-shadow: none; border-color: transparent;"
                    type="text"
                    wire:model.live.debounce.300ms="term"
                    placeholder="Place Name"
                    id="placeName">
                <label for="placeName"><small><i class="bi bi-search me-2"></i>Property Name</small></label>
            </div>

            <div class="form-floating">
                <input
                    class="form-control form-control-sm "
                    style="outline: none;  box-shadow: none; border-color: transparent;"
                    type="number"
                    wire:model.live.debounce.300ms="cost"
                    placeholder="Price Cap"
                    id="placeCost">
                <label for="placeCost"><small><span class="me-2">₱</span>Price Cap</small></label>
            </div>

            <div class="form-floating">
                <input
                    class="form-control form-control-sm"
                    style="outline: none;  box-shadow: none; border-color: transparent;"
                    type="text"
                    wire:model.live.debounce.300ms="address"
                    placeholder="Location"
                    id="placeLocation">
                <label for="placeLocation"><small><i class="bi bi-geo-alt me-2"></i>Location</small></label>
            </div>

            <div class="form-floating">
                <select wire:model.live="type"
                    class="form-select form-control-sm "
                    style="outline: none;  box-shadow: none; border-color: transparent; font-size: 0.875rem;"
                    id="placeType"
                    aria-label="Place Type">
                    <option value="" selected>All</option>
                    <option value="apartment">Apartment</option>
                    <option value="condo">Condo</option>
                    <option value="Room">Room</option>
                    <option value="Bedspace">Bedspace</option>
                </select>
                <label for="placeType"><small><i class="bi bi-justify-right me-2"></i>Place Type</small></label>
            </div>

            <div class="form-floating">
                <select wire:model.live=""
                    class="form-select form-control-sm rounded-4"
                    style="outline: none;  box-shadow: none; border-color: transparent; font-size: 0.875rem;"
                    id="placeType"
                    aria-label="Place Type">
                    <option value="" selected>for All</option>
                    <option value="apartment">for Male</option>
                    <option value="condo">for Female</option>
                </select>
                <label for="placeType"><small><i class="bi bi-gender-ambiguous me-2"></i>Gender</small></label>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row slide-in-up">
            @foreach ($properties as $property)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 p-2 ">
                <a href="{{ route('properties.show', $property->id) }}" class="text-decoration-none ">
                    <div class="card border-white border-3 shadow zoom-card">

                        @php
                        $images = json_decode($property->images, true) ?? [];
                        @endphp

                        @if(!empty($images))
                        <div id="carousel-{{ $property->id }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner rounded">
                                @foreach($images as $index => $img)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ Storage::url($img) }}"
                                        class="d-block w-100 rounded"
                                        alt="property image"
                                        style="height: 180px; object-fit: cover;">
                                </div>
                                @endforeach
                            </div>

                            @if(count($images) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $property->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $property->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                            @endif
                        </div>
                        @endif

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title text-truncate mb-0">
                                    {{ $property->name }}
                                </h6>
                                <small class="text-muted text-truncate">
                                    {{ $property->type }}
                                </small>
                            </div>

                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">₱{{ number_format($property->cost, 2) }}</small>
                                <small class="text-muted text-truncate">
                                    {{ $property->tenant }}
                                </small>
                            </div>
                        </div>

                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            <span>{{ $properties->links() }}</span>
        </div>
    </div>
</div>