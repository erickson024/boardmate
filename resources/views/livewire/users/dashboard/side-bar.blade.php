<div class="sidebar-container d-flex flex-column flex-shrink-0 bg-light fixed-top" style="width: 250px; min-height: 100vh; z-index: 999;">
    <!-- Navigation Menu -->
    <div class="flex-grow-1 px-2 py-3 mt-5">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item mb-1">
                <a href="#"
                    wire:click.prevent="setActive('dashboard')"
                    class="nav-link {{ $activeMenu === 'dashboard' ? 'active bg-primary' : 'text-light' }} rounded-2"
                    aria-current="page">
                    <i class="fa-solid fa-gauge me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="#"
                    wire:click.prevent="setActive('boards')"
                    class="nav-link {{ $activeMenu === 'boards' ? 'active bg-primary' : 'text-light' }} rounded-2">
                    <i class="fa-solid fa-table-columns me-2"></i>
                    Boards
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="#"
                    wire:click.prevent="setActive('tasks')"
                    class="nav-link {{ $activeMenu === 'tasks' ? 'active bg-primary' : 'text-light' }} rounded-2">
                    <i class="fa-solid fa-list-check me-2"></i>
                    Tasks
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="#"
                    wire:click.prevent="setActive('team')"
                    class="nav-link {{ $activeMenu === 'team' ? 'active bg-primary' : 'text-light' }} rounded-2">
                    <i class="fa-solid fa-users me-2"></i>
                    Team
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="#"
                    wire:click.prevent="setActive('analytics')"
                    class="nav-link {{ $activeMenu === 'analytics' ? 'active bg-primary' : 'text-light' }} rounded-2">
                    <i class="fa-solid fa-chart-line me-2"></i>
                    Analytics
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="#"
                    wire:click.prevent="setActive('settings')"
                    class="nav-link {{ $activeMenu === 'settings' ? 'active bg-primary' : 'text-light' }} rounded-2">
                    <i class="fa-solid fa-gear me-2"></i>
                    Settings
                </a>
            </li>
        </ul>
    </div>


    <style>
        .sidebar-container {
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-container .nav-link {
            transition: all 0.2s ease-in-out;
            font-weight: 500;
        }

        .sidebar-container .nav-link:not(.active):hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-container .dropdown-menu {
            margin-top: 0.5rem;
        }

        .sidebar-container .dropdown-item {
            transition: all 0.2s ease-in-out;
        }

        .sidebar-container .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</div>