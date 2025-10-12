<div class="mt-3">
    <div class="container">
        <p class="mb-3 fs-5 fw-medium">Your Uploaded Properties</p>

        @if($properties->isEmpty())
        <p>You haven't uploaded any properties yet.</p>
        @else
        <div class="row">
            @foreach($properties as $property)
             @php
                        $images = json_decode($property->images, true) ?? [];
                    @endphp
            <div class="col-3 mb-3">
                <div class="card shadow border-0">
                    <img
                        src="{{ isset($images[0]) ? asset('storage/' . $images[0]) : asset('images/default-property.png') }}"
                        class="card-img-top"
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
                            <p>Are you sure you want to delete
                                <strong>{{ $property->name }}</strong>?
                            </p>
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