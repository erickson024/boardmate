<div class="container py-3">
    <div class="row gx-3">
        <div class="col-lg-3">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-light rounded-4 shadow border">
                        <div class="d-flex justify-content-center mt-3">
                            <div
                                style="width:110px; height:110px; border-radius:50%; overflow:hidden;
                                       border:4px solid #212529; box-shadow:0 .5rem 1rem rgba(0,0,0,.15);
                                       background-size: cover; background-position:center;
                                       background-image: url('{{ auth()->user()->avatar
                                       ? asset('storage/' . auth()->user()->avatar)
                                       : asset('images/default-avatar.png') }}');">
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h6 class="card-title fw-semibold mb-0">
                                {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                            </h6>
                            <small class="text-muted d-block mb-3"><i class="bi bi-geo-alt"></i> {{ auth()->user()->address }}</small>

                            <div class="mb-3 mt-0">
                                <a href="#" class="btn btn-sm btn-dark" title="Meta"><i class="bi bi-meta"></i></a>
                                <a href="#" class="btn btn-sm btn-dark" title="Discord"><i class="bi bi-discord"></i></a>
                                <a href="#" class="btn btn-sm btn-dark" title="Linked"><i class="bi bi-linkedin"></i></a>
                            </div>
                            <a href="{{ route('update-profile') }}" class="btn btn-dark btn-sm rounded-pill px-4">
                                Update Profile
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="row d-flex flex-column gap-3">
                <div class="col-12">
                    <button
                        type="button"
                        wire:click="openConnections"
                        class="w-100 text start d-flex align-items-center justify-content-between p-2 rounded-4 bg-light shadow-sm border-1 text-decoration-none"
                        aria-label="Open connections">

                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3 bg-dark text-white"
                                style="width: 56px; height: 56px;">
                                <i class="bi bi-globe-asia-australia fs-4"></i>
                            </div>

                            <div class="lh-1">
                                <small class="fw-medium text-muted text-uppercase">Promoted List</small>
                                <div class="d-flex align-items-baseline gap-2">
                                    <span class="fs-6 fw-bold">Coming Soon</span>
                                </div>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="col-12">
                <button
                    type="button"
                    wire:click="openConnections"
                    class="w-100 text start d-flex align-items-center justify-content-between p-2 rounded-4 bg-light shadow-sm border-1 text-decoration-none"
                    aria-label="Open connections">

                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-3 bg-dark text-white"
                            style="width: 56px; height: 56px;">
                            <i class="bi bi-bookmark-check-fill fs-4"></i>
                        </div>

                        <div class="lh-1">
                            <small class="fw-medium text-muted text-uppercase">Saved Property</small>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="fs-6 fw-bold">Coming Soon</span>
                            </div>
                        </div>
                    </div>
                </button>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="col-12">
                <button
                    type="button"
                    wire:click="openConnections"
                    class="w-100 text start d-flex align-items-center justify-content-between p-2 rounded-4 bg-light shadow-sm border-1 text-decoration-none"
                    aria-label="Open connections">

                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-3 bg-dark text-white"
                            style="width: 56px; height: 56px;">
                            <i class="bi bi-house-door-fill fs-4" aria-hidden="true"></i>
                        </div>

                        <div class="lh-1">
                            <small class="fw-medium text-muted text-uppercase">Property Hosted</small>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="fs-5 fw-bold">{{ auth()->user()->properties()->count() }}</span>
                            </div>
                        </div>
                    </div>
                </button>
            </div>
        </div>


    </div>
</div>