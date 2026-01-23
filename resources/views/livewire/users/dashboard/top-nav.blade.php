<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-light shadow-sm">
    <div class="container-fluid px-4">
        <!-- Left Side: Back Button and Brand -->
        <div class="d-flex align-items-center">
            <a href="/" class="btn btn-dark btn-sm me-3 fs-6 d-flex align-items-center justify-content-center">
                <i class="bi bi-arrow-bar-left"></i>
            </a>
            <x-logo-dark style="width:30px;" /> <span class="navbar-brand mb-0 fs-6 fw-semibold text-dark"><small>BoardMate</small></span>
        </div>

        <!-- Right Side -->
        <div class="d-flex align-items-center">
          
        </div>
    </div>
    <style>
        .navbar {
            z-index: 1000;
        }

        .navbar .btn-outline-light:hover {
            transform: translateX(-2px);
            transition: transform 0.2s ease-in-out;
        }

        .navbar .dropdown-menu {
            min-width: 200px;
        }

        .navbar .dropdown-item {
            transition: all 0.2s ease-in-out;
        }

        .navbar .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</nav>