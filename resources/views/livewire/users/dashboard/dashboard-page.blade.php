<div class="dashboard-wrapper vh-100 overflow-hidden">

    <div class="d-flex">
        <!-- Fixed Sidebar -->
        <div class="sidebar-left bg-light" id="sidebar" wire:ignore.self style="width: 270px; height: calc(100vh - 50px); position: fixed; top: 50px; left: 0; overflow-y: hidden; z-index: 999; transition: all 0.3s ease; display: flex; flex-direction: column;">

            <div class="px-3 pb-3 pt-3 flex-grow-1" style="overflow-y: auto; overflow-x: hidden;">
                <div class="d-flex flex-column gap-3" id="buttonContainer">
                    <!-- Profile Section -->
                    <button
                        type="button"
                        wire:click="setTab('user-stat')"
                        wire:loading.attr="disabled"
                        wire:target="setTab('user-stat')"
                        class="btn rounded-4 text-start position-relative overflow-hidden {{ $currentTab === 'user-stat' ? 'btn-white text-dark shadow-sm' : 'btn-light border' }}"
                        style="transition: all 0.3s ease; --bs-btn-hover-bg: transparent; --bs-btn-hover-border-color: var(--bs-border-color);"
                        onmouseover="if(!'{{ $currentTab === 'user-stat' }}') this.classList.add('shadow-sm')"
                        onmouseout="if(!'{{ $currentTab === 'user-stat' }}') this.classList.remove('shadow-sm')">

                        <div class="d-flex align-items-center justify-content-center">
                            <span
                                class="d-inline-flex align-items-center justify-content-center rounded-3 icon-wrapper {{ $currentTab === 'user-stat' ? 'bg-dark text-white' : 'bg-light text-dark' }}"
                                style="width: 42px; height: 42px; min-width: 42px; transition: all 0.3s ease;">
                                <i class="fa-solid fa-user fa-fw"></i>
                            </span>

                            <div class="flex-grow-1 sidebar-text ms-3 text-start">
                                <small class="fw-semibold d-block">Profile</small>
                                <small class="text-muted d-block" style="font-size: 0.75rem; margin-top: 2px;">View activities</small>
                            </div>

                            <span wire:loading wire:target="setTab('user-stat')" class="ms-2 sidebar-text">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>

                            <span wire:loading.remove wire:target="setTab('user-stat')" class="sidebar-text">
                                @if($currentTab === 'user-stat')
                                <i class="fa-solid fa-chevron-right ms-2 text-muted" style="font-size: 0.75rem;"></i>
                                @endif
                            </span>
                        </div>
                    </button>

                    <!-- Property List Section -->
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

                        <div class="d-flex align-items-center justify-content-center">
                            <span
                                class="d-inline-flex align-items-center justify-content-center rounded-3 icon-wrapper {{ $currentTab === 'property-list' ? 'bg-dark text-light' : 'bg-light text-dark' }}"
                                style="width: 42px; height: 42px; min-width: 42px; transition: all 0.3s ease;">
                                <i class="fa-solid fa-house fa-fw"></i>
                            </span>

                            <div class="flex-grow-1 sidebar-text ms-3 text-start">
                                <small class="fw-semibold d-block">Property List</small>
                                <small class="text-muted d-block" style="font-size: 0.75rem; margin-top: 2px;">Manage properties</small>
                            </div>

                            <span wire:loading wire:target="setTab('property-list')" class="ms-2 sidebar-text">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>

                            <span wire:loading.remove wire:target="setTab('property-list')" class="sidebar-text">
                                @if($currentTab === 'property-list')
                                <i class="fa-solid fa-chevron-right ms-2 text-muted" style="font-size: 0.75rem;"></i>
                                @endif
                            </span>
                        </div>
                    </button>
                    @endif

                    <!-- Saved property Section -->
                    <button
                        type="button"
                        wire:click="setTab('')"
                        wire:loading.attr="disabled"
                        wire:target="setTab('')"
                        class="btn rounded-4 text-start position-relative overflow-hidden {{ $currentTab === '' ? 'btn-white text-dark shadow-sm' : 'btn-light border' }}"
                        style="transition: all 0.3s ease; --bs-btn-hover-bg: transparent; --bs-btn-hover-border-color: var(--bs-border-color);"
                        onmouseover="if(!'{{ $currentTab === '' }}') this.classList.add('shadow-sm')"
                        onmouseout="if(!'{{ $currentTab === '' }}') this.classList.remove('shadow-sm')">

                        <div class="d-flex align-items-center justify-content-center">
                            <span
                                class="d-inline-flex align-items-center justify-content-center rounded-3 icon-wrapper {{ $currentTab === '' ? 'bg-dark text-white' : 'bg-light text-dark' }}"
                                style="width: 42px; height: 42px; min-width: 42px; transition: all 0.3s ease;">
                                <i class="fa-solid fa-bookmark fa-fw"></i>
                            </span>

                            <div class="flex-grow-1 sidebar-text ms-3 text-start">
                                <small class="fw-semibold d-block">Saved Property</small>
                                <small class="text-muted d-block" style="font-size: 0.75rem; margin-top: 2px;">View saved listings</small>
                            </div>

                            <span wire:loading wire:target="setTab('')" class="ms-2 sidebar-text">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>

                            <span wire:loading.remove wire:target="setTab('')" class="sidebar-text">
                                @if($currentTab === '')
                                <i class="fa-solid fa-chevron-right ms-2 text-muted" style="font-size: 0.75rem;"></i>
                                @endif
                            </span>
                        </div>
                    </button>

                    <!-- Messages Section -->
                    <button
                        type="button"
                        wire:click="setTab('messages')"
                        wire:loading.attr="disabled"
                        wire:target="setTab('messages')"
                        class="btn rounded-4 text-start position-relative overflow-hidden {{ $currentTab === 'messages' ? 'btn-white text-dark shadow-sm' : 'btn-light border' }}"
                        style="transition: all 0.3s ease; --bs-btn-hover-bg: transparent; --bs-btn-hover-border-color: var(--bs-border-color);"
                        onmouseover="if(!'{{ $currentTab === 'messages' }}') this.classList.add('shadow-sm')"
                        onmouseout="if(!'{{ $currentTab === 'messages' }}') this.classList.remove('shadow-sm')">

                        <div class="d-flex align-items-center justify-content-center">
                            <span
                                class="d-inline-flex align-items-center justify-content-center rounded-3 icon-wrapper {{ $currentTab === 'messages' ? 'bg-dark text-white' : 'bg-light text-dark' }}"
                                style="width: 42px; height: 42px; min-width: 42px; transition: all 0.3s ease;">
                                <i class="bi bi-chat-dots-fill"></i>
                            </span>

                            <div class="flex-grow-1 sidebar-text ms-3 text-start">
                                <small class="fw-semibold d-block">Messages</small>
                                <small class="text-muted d-block" style="font-size: 0.75rem; margin-top: 2px;">View conversations</small>
                            </div>

                            <span wire:loading wire:target="setTab('messages')" class="ms-2 sidebar-text">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>

                            <span wire:loading.remove wire:target="setTab('messages')" class="sidebar-text">
                                @if($currentTab === 'messages')
                                <i class="fa-solid fa-chevron-right ms-2 text-muted" style="font-size: 0.75rem;"></i>
                                @endif
                            </span>
                        </div>
                    </button>

                    <!-- Connection Section -->
                    <button
                        type="button"
                        wire:click="setTab('connection')"
                        wire:loading.attr="disabled"
                        wire:target="setTab('connection')"
                        class="btn rounded-4 text-start position-relative overflow-hidden {{ $currentTab === 'connection' ? 'btn-white text-dark shadow-sm' : 'btn-light border' }}"
                        style="transition: all 0.3s ease; --bs-btn-hover-bg: transparent; --bs-btn-hover-border-color: var(--bs-border-color);"
                        onmouseover="if(!'{{ $currentTab === 'connection' }}') this.classList.add('shadow-sm')"
                        onmouseout="if(!'{{ $currentTab === 'connection' }}') this.classList.remove('shadow-sm')">

                        <div class="d-flex align-items-center justify-content-center">
                            <span
                                class="d-inline-flex align-items-center justify-content-center rounded-3 icon-wrapper {{ $currentTab === 'connection' ? 'bg-dark text-light' : 'bg-light text-dark' }}"
                                style="width: 42px; height: 42px; min-width: 42px; transition: all 0.3s ease;">
                                <i class="fa-solid fa-user-group fa-fw"></i>
                            </span>

                            <div class="flex-grow-1 sidebar-text ms-3 text-start">
                                <small class="fw-semibold d-block">Connection</small>
                                <small class="text-muted d-block" style="font-size: 0.75rem; margin-top: 2px;">Your network</small>
                            </div>

                            <span wire:loading wire:target="setTab('connection')" class="ms-2 sidebar-text">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>

                            <span wire:loading.remove wire:target="setTab('connection')" class="sidebar-text">
                                @if($currentTab === 'connection')
                                <i class="fa-solid fa-chevron-right ms-2 text-muted" style="font-size: 0.75rem;"></i>
                                @endif
                            </span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Toggle Button at Bottom -->
            <div class="d-flex justify-content-end toggle-container" wire:ignore style="padding: 1rem;">
                <button 
                    id="toggleSidebar" 
                    class="btn btn-sm btn-dark flex-shrink-0"
                    style="border-radius: 6px; padding: 6px 10px; transition: all 0.3s ease; width: 40px; height: 32px; display: flex; align-items: center; justify-content: center;"
                    onclick="toggleSidebar()">
                    <i class="fa-solid fa-chevron-left" id="toggleIcon"></i>
                </button>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="main-content" id="mainContent" wire:ignore.self style="margin-left: 270px; margin-top: 50px; width: calc(100% - 270px); transition: all 0.3s ease;">
            @if ($currentTab === 'user-stat')
            @livewire('users.dashboard.user-stat')
            @elseif ($currentTab === 'property-list')
            @livewire('users.dashboard.property-list')
            @elseif ($currentTab === 'messages')
            @livewire('users.dashboard.messages')
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
            background: #888;
            border-radius: 3px;
        }

        .sidebar-left::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Collapsed sidebar styles */
        .sidebar-left.collapsed {
            width: 70px !important;
        }

        .sidebar-left.collapsed .px-3 {
            padding-left: 0.625rem !important;
            padding-right: 0.625rem !important;
        }

        .sidebar-left.collapsed #buttonContainer {
            gap: 0.75rem !important;
        }

        .sidebar-left.collapsed .sidebar-text {
            opacity: 0 !important;
            visibility: hidden !important;
            width: 0 !important;
            margin: 0 !important;
            display: none !important;
        }

        .sidebar-left.collapsed .btn {
            padding: 0.5rem !important;
            border-radius: 10px !important;
            justify-content: center !important;
            align-items: center !important;
            display: flex !important;
            width: 50px !important;
            height: 50px !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .sidebar-left.collapsed .btn > div {
            justify-content: center !important;
            align-items: center !important;
            width: 100% !important;
        }

        .sidebar-left.collapsed .icon-wrapper {
            margin: 0 !important;
            width: 38px !important;
            height: 38px !important;
        }

        .sidebar-left.collapsed #toggleSidebar {
            margin: 0 auto !important;
        }

        .sidebar-left.collapsed .toggle-container {
            justify-content: center !important;
            padding: 1rem !important;
        }

        /* Better active state for collapsed sidebar */
        .sidebar-left.collapsed .btn-white {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .sidebar-left.collapsed .btn-light {
            background-color: transparent !important;
            border: none !important;
        }

        .sidebar-left.collapsed .btn-white .icon-wrapper {
            background-color: #212529 !important;
            color: white !important;
        }

        .sidebar-left.collapsed .btn-light:hover .icon-wrapper {
            background-color: #e9ecef !important;
        }

        /* Smooth transitions */
        .sidebar-text {
            transition: opacity 0.3s ease, visibility 0.3s ease, width 0.3s ease;
            white-space: nowrap;
        }

        .icon-wrapper {
            transition: all 0.3s ease !important;
        }

        .btn {
            transition: all 0.3s ease !important;
        }
    </style>

    <script>
        function toggleSidebar() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            localStorage.setItem('sidebarCollapsed', !isCollapsed);
            applySidebarState();
        }

        function applySidebarState() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (!sidebar || !mainContent || !toggleIcon) {
                // Retry after a short delay if elements not found
                setTimeout(applySidebarState, 50);
                return;
            }
            
            // Default is wide (expanded), only collapse if user has set it to collapsed
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.style.marginLeft = '70px';
                mainContent.style.width = 'calc(100% - 70px)';
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');
                
                // Dispatch custom event for grid adjustment
                window.dispatchEvent(new CustomEvent('sidebarStateChanged', { detail: { collapsed: true } }));
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.style.marginLeft = '270px';
                mainContent.style.width = 'calc(100% - 270px)';
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-left');
                
                // Dispatch custom event for grid adjustment
                window.dispatchEvent(new CustomEvent('sidebarStateChanged', { detail: { collapsed: false } }));
            }
        }

        // Apply on page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', applySidebarState);
        } else {
            applySidebarState();
        }

        // Apply after Livewire updates
        document.addEventListener('livewire:load', function() {
            applySidebarState();
        });

        document.addEventListener('livewire:navigated', function() {
            applySidebarState();
        });

        // For Livewire v3
        if (typeof Livewire !== 'undefined') {
            Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
                succeed(({ snapshot, effect }) => {
                    setTimeout(applySidebarState, 50);
                });
            });
        }

        // Fallback: Use MutationObserver to watch for DOM changes
        const observer = new MutationObserver(function(mutations) {
            applySidebarState();
        });

        // Start observing when document is ready
        if (document.body) {
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        }
    </script>
</div>