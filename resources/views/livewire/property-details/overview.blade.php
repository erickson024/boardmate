<div>
    {{-- Top row: tenant details --}}
    <div class="row mt-2 gx-3">
        <div class="col-md-4">
            <div class="rounded border border-dark p-2">
                <span class="small">
                    We are looking for
                    <span class="fw-medium">{{ $property->tenantType }} Tenant.</span>
                </span>
            </div>
        </div>

        <div class="col-md-4 mt-2 mt-md-0">
            <div class="rounded border border-dark p-2">
                <small>
                    The host prefers
                    <span class="fw-medium">{{ $property->tenantGender }} Gender.</span>
                </small>
            </div>
        </div>

        <div class="col-md-4 mt-2 mt-md-0">
            <div class="rounded border border-dark p-2">
                <small>
                    Rental payment of
                    <span class="fw-medium">₱{{ number_format($property->cost, 0) }} monthly.</span>
                </small>
            </div>
        </div>
    </div>

    {{-- Features --}}
    <div class="row mt-3">
        <div class="col-12">
            @php
            $features = json_decode($property->feature, true) ?? [];
            @endphp

            @if(!empty($features))
            <h6 class="fw-medium mb-2"><small>Features & Amenities</small></h6>
            <div class="row g-3">
                @foreach($features as $feature)
                <div class="col-md-3 col-6">
                    <div class="feature-card d-flex align-items-center gap-2 p-3 rounded-3 bg-light border-0">
                        <i class="bi bi-check-circle-fill text-success small"></i>
                        <span class="small">{{ $feature }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Description --}}
        <div class="col-12 mt-3">
            <h6 class="fw-medium mb-1"><small>Description</small></h6>
            <div>
                @if(!empty($property->description))
                <p class="small mb-0"><small>{{ $property->description }}</small></p>
                @else
                <p class="text-muted small mb-0">No description available for this property.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Bottom buttons (footer-style, not fixed) --}}
    <footer class="mt-4">
        <div class="">
            <div class="row gx-2 gy-2">
                <div class="col-12 col-md-4">
                    <button class="btn btn-sm btn-success w-100 d-flex align-items-center justify-content-between">
                        <i class="bi bi-images"></i>
                        <small>Property gallery</small>
                    </button>
                </div>

                <div class="col-12 col-md-4">
                    <button class="btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-between">
                        <i class="bi bi-geo-alt-fill"></i>
                        <small>Property map location</small>
                    </button>
                </div>

                <div class="col-12 col-md-4">
                    <button class="btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-between">
                        <i class="bi bi-person-vcard-fill"></i>
                        <small>See the host</small>
                    </button>
                </div>

                <div class="col-12 col-md-4">
                    <button class="btn btn-sm btn-dark w-100"><small>Restriction</small></button>
                </div>
                <div class="col-12 col-md-4">
                    <button class="btn btn-sm btn-dark w-100"><small>Terms & Conditions</small></button>
                </div>
                <div class="col-12 col-md-4">
                    <button class="btn btn-sm btn-dark w-100"><small>Payment Agreement</small></button>
                </div>

            </div>
    </footer>

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