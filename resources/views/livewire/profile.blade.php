<div class="container">
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="p-4 bg-white border border-dark rounded">
                <h6 class="mb-4 ">
                    <i class="bi bi-grip-vertical"></i> Dashboard
                </h6>

                <div class="d-flex align-items-center shadow p-2 rounded gap-3"
                    style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.8), rgba(155, 89, 182, 0.8));">
                    <img
                        src="{{ auth()->user()->avatar 
                            ? asset('storage/' . auth()->user()->avatar) 
                            : asset('images/default-avatar.png') }}"
                        alt="Profile"
                        class="rounded-circle shadow-lg"
                        style="width: 100px; height: 100px; object-fit: cover;">

                    <div>
                        <h6 class="mb-1">
                            {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                        </h6>

                        <a href="{{route('update-profile')}}" class="btn btn-sm btn-dark">
                            update profile
                        </a>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-end gap-3 mt-3">
                    <div class="bg-light border p-3 w-25  shadow rounded">
                        <span class="fw-semibold">Email</span>
                        <small class="fw-light d-flex justify-content-end">{{auth()->user()->email}}</small>
                    </div>

                    <div class="bg-light border p-3 w-25  shadow rounded">
                        <span class="fw-semibold">Address</span>
                        <small class="fw-light d-flex justify-content-end">{{auth()->user()->address}}</small>
                    </div>

                    <div class="bg-light border p-3 w-25  shadow rounded">
                        <span class="fw-semibold">Joined</span>
                        <small class="fw-light d-flex justify-content-end">{{auth()->user()->created_at}}</small>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-3">
            <div class="card bg-light shadow rounded-4 mb-3 w-100 overflow-hidden">
                <div class="row g-0">
                    <!-- Left Side -->
                    <div class="col-9 d-flex flex-column justify-content-center p-3">
                        <h6 class="fw-medium mb-1">Added Property</h6>
                        <h3 class="fw-bold mb-0">{{ $count }}</h3>
                    </div>
                    <!-- Right Side Button -->
                    <div class="col-3">
                        <a href="#"
                            class="btn btn-secondary h-100 w-100 rounded-0 d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>