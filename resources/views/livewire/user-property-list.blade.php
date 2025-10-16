<div class="mt-3">
    <div class="container">
        <p class="mb-3 fs-6 fw-medium">Uploaded Properties</p>

        <div class="d-flex align-items-center justify-content-between bg-primary-subtle border-0 shadow-sm p-3 my-2 ">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="bi bi-patch-check-fill fs-5"></i>
                </div>
                <div>
                    <small class="fw-semibold text-dark">Be a verified host</small><br>
                    <small class="text-muted">Build trust and attract more tenants.</small>
                </div>
            </div>
            <button class="btn btn-sm btn-primary rounded-5 px-3"><small>Verify Now</small></button>
        </div>

        @if($properties->isEmpty())
        <div class="bg-white border-0 shadow-sm p-4 my-3 rounded-4 text-center">
            <p class="fw-semibold text-dark mb-1">No properties uploaded yet</p>
            <small class="text-muted d-block mb-3">
                Start sharing your first property to attract tenants.
            </small>

            <img
                src="{{ asset('images/image9.gif') }}"
                alt="No properties yet"
                class="img-fluid mt-2"
                style="max-width: 180px; opacity: 0.95;">
        </div>

        @else
        <div class="row">
            @foreach($properties as $property)
            @php
            $images = json_decode($property->images, true) ?? [];
            @endphp
            <div class="{{ $colSize }} mb-3">
                <div class="card shadow-sm border-0">
                    <img
                        src="{{ isset($images[0]) ? asset('storage/' . $images[0]) : asset('images/default-property.png') }}"
                        class="card-img-top w-100"
                        alt="{{ $property->name }}"
                        style="height: 150px; object-fit: cover;">

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="fw-semibold">{{ $property->name }}</small>
                            <button type="button" class="btn btn-dark btn-sm"
                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $property->id }}">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for this specific property -->
            <div class="modal fade" id="deleteModal{{ $property->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <div class="d-flex flex-column align-items-center">
                                <!-- Confirmation text -->
                                <p class="fs-6 mb-3">
                                    Are you sure you want to delete
                                    <span class="fw-semibold text-dark">{{ $property->name }}</span>?
                                </p>

                                <!-- Preview image -->
                                <div class="border rounded-3 overflow-hidden shadow-sm" style="max-width: 300px;">
                                    <img
                                        src="{{ isset($images[0]) ? asset('storage/' . $images[0]) : asset('images/default-property.png') }}"
                                        class="img-fluid"
                                        alt="{{ $property->name }}"
                                        style="object-fit: cover; height: 180px; width: 100%;">
                                </div>

                                <!-- Warning text -->
                                <small class="text-muted mt-3">
                                    This action cannot be undone.
                                </small>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal">Cancel</button>
                            <button wire:click="deleteProperty({{ $property->id }})"
                                class="btn btn-dark btn-sm"
                                data-bs-dismiss="modal">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            @endif
        </div>


    </div>