<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-6 vh-100 d-flex flex-column justify-content-center px-5 gap-4">
            <p class="fs-1">
                Hello,
                <span class="fw-medium">
                    {{ ucfirst(auth()->user()->firstName) }} {{ ucfirst(auth()->user()->lastName) }}
                </span>
            </p>

            <p class="fs-6 text-muted">
                You’re officially a verified Host — you can now host a property and start accepting tenants. Begin your journey to successful property management today.
                <i class="bi bi-patch-check-fill text-primary ms-1"></i>
            </p>

            <div class="">
                <a href="{{route('home')}}" class="btn btn-sm btn-dark" wire:navigate>
                    <span class="fw-semibold"><small>Property List</small></span>
                </a>

                <a href="{{route('property-registration')}}" class="btn btn-sm btn-outline-dark" wire:navigate>
                    <span class="fw-semibold"><small>Register a property</small></span>
                </a>
            </div>

        </div>

        <div class="col-12 col-md-6  p-0 vh-100 position-relative overflow-hidden d-flex align-items-center">
            <img
                src="{{ asset('images/image9.jpg') }}"
                alt="Professional host verification - Happy property manager with verified documentation"
                class="w-100"
                style="object-fit: cover; object-position: center top; min-height: 100%;"
                loading="lazy"
                decoding="async">

            <!-- Subtle vignette effect -->
            <div class="position-absolute top-0 start-0 w-100 h-100"
                style="background: radial-gradient(circle at center, transparent 40%, rgba(0,0,0,0.08) 100%); pointer-events: none;"></div>
        </div>

    </div>
</div>