<div class="container-fluid">
    <div class="row">

        {{-- SIDEBAR --}}
        <div class="col-2 p-0">
            <nav class="sidebar vh-100 bg-body-tertiary border shadow-sm d-flex flex-column p-2">

                {{-- Logo --}}
                <div class="text-center rounded shadow-sm p-2 mb-4 fw-medium">
                    <small>
                        <x-logo-dark style="width:25px;" />
                        <span class="nav-label fw-semibold small">Control Panel</span>
                    </small>
                </div>

                {{-- NAV ITEMS --}}
                <div class="d-flex flex-column gap-2">

                    @foreach ($this->navItems as $item)
                    <button
                        wire:click="setTab('{{ $item['key'] }}')"
                        wire:loading.attr="disabled"
                        class="btn btn-sm btn-dark nav-btn d-flex align-items-center py-2 gap-2 position-relative
                                   {{ $active === $item['key'] ? 'active' : '' }}">

                        {{-- Icon --}}
                        <i class="bi {{ $item['icon'] }}"></i>

                        {{-- Label --}}
                        <span class="nav-label fw-medium small">
                            {{ $item['label'] }}
                        </span>

                        {{-- Badge --}}
                        @if (!is_null($item['badge']))
                        <span class="badge text-bg-secondary nav-badge">
                            {{ $item['badge'] }}
                        </span>
                        @endif

                        {{-- Spinner --}}
                        <span
                            wire:loading
                            wire:target="setTab('{{ $item['key'] }}')"
                            class="spinner-border spinner-border-sm ms-auto">
                        </span>
                    </button>
                    @endforeach

                </div>

                {{-- Bottom / Settings --}}
                <div class="mt-auto">

                    {{-- Collapsible content --}}
                    <div class="collapse" id="collapseExample">

                        {{-- Settings button --}}
                        <x-buttons.small-button
                            class="fw-semibold w-100 d-flex align-items-center justify-content-center justify-content-lg-start">
                            <i class="bi bi-gear-fill"></i>
                            <span class="nav-label d-none d-lg-inline ms-2">Settings</span>
                        </x-buttons.small-button>

                        {{-- Log Out --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-buttons.small-button
                                type="submit"
                                class="w-100 fw-semibold mt-1 d-flex align-items-center justify-content-center justify-content-lg-start">
                                <i class="bi bi-box-arrow-right"></i>
                                <span class="nav-label d-none d-lg-inline ms-2">Log Out</span>
                            </x-buttons.small-button>
                        </form>

                    </div>

                    {{-- Toggle button --}}
                    <div class="mt-2 mb-0">
                        <button
                            class="btn btn-sm btn-outline-dark shadow-sm py-2 w-100"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseExample"
                            aria-expanded="false"
                            aria-controls="collapseExample">

                            <div class="d-flex justify-content-between align-items-center w-100">
                                {{-- User info hidden on small screens --}}
                                <div class="d-flex flex-column lh-1 text-start nav-label">
                                    <small class="fw-semibold">{{ Auth::user()->firstName }}</small>
                                    <small class="text-secondary">{{ Auth::user()->role }}</small>
                                </div>

                                {{-- Gear icon always visible --}}
                                <i class="bi bi-person-fill-gear ms-2"></i>
                            </div>
                        </button>
                    </div>

                </div>

            </nav>
        </div>

        {{-- CONTENT --}}
        <div class="col-10 p-2 p-lg-4" style="height: 100vh; overflow-y: auto; overflow-x: hidden;">

            @if ($active === 'environment')
            <livewire:admin.environment-status />
            @elseif ($active === 'host')
            <livewire:admin.host-requests />
            @elseif ($active === 'users')
            <livewire:admin.users />
            @elseif ($active === 'properties')
            <livewire:admin.properties />
            @elseif ($active === 'messages')
            <livewire:admin.messages />
            @endif

        </div>


    </div>

    <style>
        .sidebar {
            width: 220px;
            transition: width 0.2s ease;
            overflow-x: hidden;
        }

        .nav-label {
            white-space: nowrap;
        }

        .nav-badge {
            margin-left: auto;
        }


        @media (max-width: 991px) {
            .sidebar {
                width: 64px !important;
            }

            .sidebar .nav-badge {
                display: none !important;
            }

            .sidebar .nav-label {
                display: none !important;
            }

            .sidebar .nav-btn {
                justify-content: center !important;
            }

            .sidebar .collapse .nav-btn {
                justify-content: flex-start;
            }
        }
    </style>

</div>