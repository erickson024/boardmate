<div class="container-fluid">

    <div class="row gx-3">
        <!--Profile Card-->
        <div class="col-12">
            <div class="profile-card  position-relative">
                <div class="d-flex flex-column align-items-center justify-content-center mb-3 mt-3">
                    <div class="mb-2">
                        <x-profile-image size="160" />
                    </div>


                    <h5 class="fw-semibold text-center">
                        {{ ucfirst(auth()->user()->firstName) }}
                        {{ ucfirst(auth()->user()->lastName) }}
                    </h5>

                    @if(auth()->check() && auth()->user()->role === 'host')
                    <div class="text-center">
                        <span class="badge bg-success d-inline-flex align-items-center gap-1">
                            <i class="bi bi-patch-check-fill"></i>
                            Verified Host
                        </span>
                    </div>
                    @else
                    <div class="text-center">
                        <span class="badge bg-primary d-inline-flex align-items-center gap-1">
                            Tenant
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-5 mt-4 ">
            <div class="p-4 bg-primary">
                <p>content</p>
            </div>
        </div>

        <div class="col-7 mt-4 ">
            <div class="p-4 bg-primary">
                <p>endorse content</p>
            </div>
        </div>
    </div>
</div>