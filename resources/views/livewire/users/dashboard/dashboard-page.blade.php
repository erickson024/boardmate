<div class="dashboard-wrapper vh-100 overflow-hidden">

    <div class="d-flex">
        <!-- Fixed Sidebar -->
        <div class="sidebar-left bg-light " style="width: 270px; height: 100vh; position: fixed; top: 50px; left: 0; overflow-y: auto; z-index: 999;">
            <div class="p-3">
                <div class="d-flex flex-column gap-3">
                    <button
                        type="button"
                        wire:click="setTab('user-stat')"
                        wire:loading.attr="disabled"
                        wire:target="setTab('user-stat')"
                        class="btn rounded-4 text-start position-relative overflow-hidden {{ $currentTab === 'user-stat' ? 'btn-white text-dark shadow-sm' : 'btn-light border' }}"
                        style="transition: all 0.3s ease; --bs-btn-hover-bg: transparent; --bs-btn-hover-border-color: var(--bs-border-color);"
                        onmouseover="if(!'{{ $currentTab === 'user-stat' }}') this.classList.add('shadow-sm')"
                        onmouseout="if(!'{{ $currentTab === 'user-stat' }}') this.classList.remove('shadow-sm')">

                        <div class="d-flex align-items-center">
                            <span
                                class="me-3 d-inline-flex align-items-center justify-content-center rounded-3 icon-wrapper {{ $currentTab === 'user-stat' ? 'bg-dark text-white' : 'bg-light text-dark' }}"
                                style="width: 42px; height: 42px; transition: all 0.3s ease;">
                                <i class="fa-solid fa-user fa-fw"></i>
                            </span>

                            <div class="flex-grow-1">
                                <small class="fw-semibold d-block">Profile</small>
                                <small class="text-muted d-block" style="font-size: 0.75rem; margin-top: 2px;">View activities</small>
                            </div>

                            <span wire:loading wire:target="setTab('user-stat')" class="ms-2">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>

                            <span wire:loading.remove wire:target="setTab('user-stat')">
                                @if($currentTab === 'user-stat')
                                <i class="fa-solid fa-chevron-right ms-2 text-muted" style="font-size: 0.75rem;"></i>
                                @endif
                            </span>
                        </div>
                    </button>


                    @if(auth()->check() && auth()->user()->role === 'host')
                    <button
                        type="button"
                        wire:click="setTab('property-list')"
                        wire:loading.attr="disabled"
                        wire:target="setTab('property-list')"
                        class="btn rounded-4 text-start position-relative overflow-hidden {{ $currentTab === 'property-list' ? 'btn-white text-dark shadow-sm' : 'btn-light border' }}"
                        style="transition: all 0.3s ease; --bs-btn-hover-bg: transparent; --bs-btn-hover-border-color: var(--bs-border-color);"
                        onmouseover="if(!'{{ $currentTab === 'property-list' }}') this.classList.add('shadow-sm')"
                        onmouseout="if(!'{{ $currentTab === 'property-list' }}') this.classList.remove('shadow-sm')">

                        <div class="d-flex align-items-center">
                            <span
                                class="me-3 d-inline-flex align-items-center justify-content-center rounded-3 icon-wrapper {{ $currentTab === 'property-list' ? 'bg-dark text-light' : 'bg-light text-dark' }}"
                                style="width: 42px; height: 42px; transition: all 0.3s ease;">
                                <i class="fa-solid fa-house fa-fw"></i>
                            </span>

                            <div class="flex-grow-1">
                                <small class="fw-semibold d-block">Property List</small>
                                <small class="text-muted d-block" style="font-size: 0.75rem; margin-top: 2px;">Manage properties</small>
                            </div>

                            <span wire:loading wire:target="setTab('property-list')" class="ms-2">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>

                            <span wire:loading.remove wire:target="setTab('property-list')">
                                @if($currentTab === 'property-list')
                                <i class="fa-solid fa-chevron-right ms-2 text-muted" style="font-size: 0.75rem;"></i>
                                @endif
                            </span>
                        </div>
                    </button>
                    @endif

                    <button
                        type="button"
                        wire:click="setTab('user-stat')"
                        wire:loading.attr="disabled"
                        wire:target="setTab('user-stat')"
                        class="btn rounded-4 text-start position-relative overflow-hidden {{ $currentTab === 'user-stat' ? 'btn-white text-dark shadow-sm' : 'btn-light border' }}"
                        style="transition: all 0.3s ease; --bs-btn-hover-bg: transparent; --bs-btn-hover-border-color: var(--bs-border-color);"
                        onmouseover="if(!'{{ $currentTab === 'user-stat' }}') this.classList.add('shadow-sm')"
                        onmouseout="if(!'{{ $currentTab === 'user-stat' }}') this.classList.remove('shadow-sm')">

                        <div class="d-flex align-items-center">
                            <span
                                class="me-3 d-inline-flex align-items-center justify-content-center rounded-3 icon-wrapper {{ $currentTab === 'user-stat' ? 'bg-dark text-white' : 'bg-light text-dark' }}"
                                style="width: 42px; height: 42px; transition: all 0.3s ease;">
                                <i class="fa-solid fa-bookmark fa-fw"></i>
                            </span>

                            <div class="flex-grow-1">
                                <small class="fw-semibold d-block">Saved Property</small>
                                <small class="text-muted d-block" style="font-size: 0.75rem; margin-top: 2px;">View saved listings</small>
                            </div>

                            <span wire:loading wire:target="setTab('user-stat')" class="ms-2">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>

                            <span wire:loading.remove wire:target="setTab('user-stat')">
                                @if($currentTab === 'user-stat')
                                <i class="fa-solid fa-chevron-right ms-2 text-muted" style="font-size: 0.75rem;"></i>
                                @endif
                            </span>
                        </div>
                    </button>


                    <button
                        type="button"
                        wire:click="setTab('connection')"
                        wire:loading.attr="disabled"
                        wire:target="setTab('connection')"
                        class="btn rounded-4 text-start position-relative overflow-hidden {{ $currentTab === 'connection' ? 'btn-white text-dark shadow-sm' : 'btn-light border' }}"
                        style="transition: all 0.3s ease; --bs-btn-hover-bg: transparent; --bs-btn-hover-border-color: var(--bs-border-color);"
                        onmouseover="if(!'{{ $currentTab === 'connection' }}') this.classList.add('shadow-sm')"
                        onmouseout="if(!'{{ $currentTab === 'connection' }}') this.classList.remove('shadow-sm')">

                        <div class="d-flex align-items-center">
                            <span
                                class="me-3 d-inline-flex align-items-center justify-content-center rounded-3 icon-wrapper {{ $currentTab === 'connection' ? 'bg-dark text-light' : 'bg-light text-dark' }}"
                                style="width: 42px; height: 42px; transition: all 0.3s ease;">
                                <i class="fa-solid fa-user-group fa-fw"></i>
                            </span>

                            <div class="flex-grow-1">
                                <small class="fw-semibold d-block">Connection</small>
                                <small class="text-muted d-block" style="font-size: 0.75rem; margin-top: 2px;">Your network</small>
                            </div>

                            <span wire:loading wire:target="setTab('connection')" class="ms-2">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>

                            <span wire:loading.remove wire:target="setTab('connection')">
                                @if($currentTab === 'connection')
                                <i class="fa-solid fa-chevron-right ms-2 text-muted" style="font-size: 0.75rem;"></i>
                                @endif
                            </span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="main-content " style="margin-left: 270px; margin-top: 50px; width:100%;">
            @if ($currentTab === 'user-stat')
            @livewire('users.dashboard.user-stat')
            @elseif ($currentTab === 'property-list')
            @livewire('users.dashboard.property-list')
            @elseif ($currentTab === 'connection')
            @livewire('users.dashboard.connection')
            @endif


        </div>
    </div>
    <style>
        .sidebar-left::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-left::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .sidebar-left::-webkit-scrollbar-thumb {
            background: #ffffff;
            border-radius: 3px;
        }

        .sidebar-left::-webkit-scrollbar-thumb:hover {
            background: #ffffff;
        }
    </style>
</div>