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

        <div class="col-12 col-md-12 col-lg-9">
            <div class="row gx-2">
                <div class="row ">
                    <!-- Promoted List -->
                    <div class="col-12 col-md-12 col-lg-4  mt-3 mt-md-0 mt-lg-0">
                        <button
                            type="button"
                            wire:click="openConnections"
                            class="w-100 text-start d-flex align-items-center gap-3 p-3 rounded-4 bg-light border-0 shadow-sm hover-shadow-sm transition-all"
                            aria-label="Open connections"
                            style="transition: all 0.2s ease;">

                            <div class="d-flex align-items-center justify-content-center rounded-3 bg-dark text-white flex-shrink-0"
                                style="width: 56px; height: 56px;">
                                <i class="bi bi-globe-asia-australia fs-4"></i>
                            </div>

                            <div class="flex-grow-1">
                                <small class="fw-medium text-muted text-uppercase d-block mb-1"><small>Promoted List</small></small>
                                <span class="fs-6 fw-semibold text-dark">Coming Soon</span>
                            </div>
                        </button>
                    </div>

                    <!-- Saved Property -->
                    <div class="col-12 col-md-12 col-lg-4 mt-3 mt-md-0 mt-lg-0">
                        <button
                            type="button"
                            wire:click="openConnections"
                            class="w-100 text-start d-flex align-items-center gap-3 p-3 rounded-4 bg-light border-0 shadow-sm hover-shadow-sm transition-all"
                            aria-label="Open saved properties"
                            style="transition: all 0.2s ease;">

                            <div class="d-flex align-items-center justify-content-center rounded-3 bg-dark text-white flex-shrink-0"
                                style="width: 56px; height: 56px;">
                                <i class="bi bi-bookmark-check-fill fs-4"></i>
                            </div>

                            <div class="flex-grow-1">
                                <small class="fw-medium text-muted text-uppercase d-block mb-1"><small>Saved Properties</small></small>
                                <span class="fs-6 fw-semibold text-dark">Coming Soon</span>
                            </div>
                        </button>
                    </div>

                    <!-- Property Hosted -->
                    <div class="col-12 col-md-12 col-lg-4 mt-3 mt-md-0 mt-lg-0">
                        <button
                            type="button"
                            wire:click="goToPropertyList"
                            class="w-100 text-start d-flex align-items-center gap-3 p-3 rounded-4 bg-light border-0 shadow-sm hover-shadow-sm transition-all"
                            aria-label="Open hosted properties"
                            style="transition: all 0.2s ease;">

                            <div class="d-flex align-items-center justify-content-center rounded-3 bg-dark text-white flex-shrink-0"
                                style="width: 56px; height: 56px;">
                                <i class="bi bi-house-door-fill fs-4"></i>
                            </div>

                            <div class="flex-grow-1">

                                <small class="fw-medium text-muted text-uppercase d-block mb-1"><small>Property Hosted</small></small>
                                <span class="fs-5 fw-bold text-dark">{{ auth()->user()->properties()->count() }}</span>

                            </div>
                        </button>
                    </div>

                    <div class="my-3 bg-light rounded shadow border">
                        <livewire:user-property-list col-size="col-lg-4" />
                    </div>
                </div>


            </div>
        </div>
    </div>

    <style>
        .hover-shadow-sm:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>

</div>