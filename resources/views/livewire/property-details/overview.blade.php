<div>
    <div class="row">
        <div class="col-6">
            <div class="d-flex flex-column justify-content-start">
                <h5 class="mb-0 fw-semibold">{{ $property->name }}</h5>
                <small class="text-muted">{{ $property->address }} | {{ $property->type }}</small>
            </div>
        </div>
        <div class="col-6">
            <div class="d-flex justify-content-end gap-2">
                <a href="" class="btn btn-dark btn-sm">
                    Inquire
                </a>

                <a href="" class="btn btn-outline-dark btn-sm">
                    Save
                </a>
            </div>
        </div>
    </div>


    <div class="row mt-2 gx-3">
        <div class="col-3">
            <div class="rounded border border-dark p-2">
                <span class="small">We are looking for <span class="fw-medium"> {{ $property->tenantType }} Tenant.</span></span>
            </div>
        </div>
        <div class="col-3">
            <div class="rounded border border-dark p-2">
                <small>The host preferred <span class="fw-medium"> {{ $property->tenantGender }} Gender.</span> </small>
            </div>
        </div>
        <div class="col-3">
            <div class="rounded border border-dark p-2">
                <small>Rental payment of <span class="fw-medium"> ₱{{ number_format($property->cost, 0) }} montly.</span>
                </small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @php
            $features = json_decode($property->feature, true) ?? [];
            @endphp
            @if(!empty($features))
            <div class="mt-4">
                <h6 class="fw-medium mb-3">Features & Amenities</h6>
                <div class="row g-3">
                    @foreach($features as $feature)
                    <div class="col-md-3">
                        <div class="feature-card d-flex align-items-center gap-2 p-3 rounded-3 bg-light border-0">
                            <i class="bi bi-check-circle-fill text-success small"></i>
                            <span class="small">{{ $feature }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="col-6 mt-4">
            <h6 class="fw-medium mb-3">Description</h6>
            <div class="p-3 rounded bg-light shadow-sm">
                @if(!empty($property->description))
                <p class="small">{{ $property->description }}</p>
                @else
                <p class="text-muted small">No description available for this property.</p>
                @endif

            </div>
        </div>

        <div class="col-6 mt-4">
            <h6 class="fw-medium mb-3">Restriction</h6>
            <div class="p-3 rounded bg-light shadow-sm">
                @if(!empty($property->restriction))
                <p class="small">{{ $property->restriction }}</p>
                @else
                <p class="text-muted small">No restriction available for this property.</p>
                @endif

            </div>
        </div>

        <div class="col-6 mt-4">
            <h6 class="fw-medium mb-3">Terms and Condition</h6>
            <div class="p-3 rounded bg-light shadow-sm">
                @if(!empty($property->terms))
                <p class="small">{{ $property->terms }}</p>
                @else
                <p class="text-muted small">No terms for this property.</p>
                @endif

            </div>
        </div>

        <div class="col-6 mt-4">
            <h6 class="fw-medium mb-3">Payment Agreement</h6>
            <div class="p-3 rounded bg-light shadow-sm">
                @if(!empty($property->payment))
                <p class="small">{{ $property->payment }}</p>
                @else
                <p class="text-muted small">No payment agreement for this property.</p>
                @endif

            </div>
        </div>
    </div>

    <style>
        .feature-card {
            transition: all 0.2s ease;
        }

        .feature-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
        }

        @media (max-width: 768px) {
            .feature-card {
                background-color: transparent !important;
            }
        }
    </style>
</div>