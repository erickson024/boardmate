<div>
    <nav class="nav flex-column bg-body-tertiary shadow-sm border p-3" style="width: 200px; height: 100vh;">
        <div class="d-flex justify-content-center">
            <span class=" fw-semibold" style="font-size: 12px;">Boardmate Admin Panel</span>
        </div>

        <div class="d-flex flex-column gap-2 mt-4">

            <x-buttons.small-button class="fw-semibold w-100">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <small>Environment Status</small>
                    </div>
                    <i class="bi bi-bar-chart-fill"></i>
                </div>
            </x-buttons.small-button>

            <x-buttons.small-button class="fw-semibold w-100">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <small>Host Request</small>
                    </div>
                    <span>0</span>
                </div>
            </x-buttons.small-button>

            <x-buttons.small-button class="fw-semibold w-100">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <small>User List</small>
                    </div>
                    <span>0</span>
                </div>
            </x-buttons.small-button>

            <x-buttons.small-button class="fw-semibold w-100">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <small>Propety List</small>
                    </div>
                    <span>0</span>
                </div>
            </x-buttons.small-button>

        </div>

        <div class="mt-auto">
            <div class="collapse" id="collapseExample">
                <x-buttons.small-button class="fw-semibold w-100">
                    <small>Settings</small>
                </x-buttons.small-button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-buttons.small-button class="w-100 fw-semibold mt-1">
                        <small>Log Out</small>
                    </x-buttons.small-button>
                </form>

            </div>
            <p class="mt-2">
                <button class="btn btn-sm btn-outline-dark shadow-sm py-2 w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="d-flex flex-column lh-1 text-start">
                            <small class="fw-semibold">{{ Auth::user()->firstName }}</small>
                            <small class="text-secondary">{{ Auth::user()->role }}</small>
                        </div>

                        <i class="bi bi-gear-fill ms-2"></i>
                    </div>
                </button>
            </p>
        </div>


    </nav>

</div>