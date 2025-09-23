<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoardMate Layout</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
   
        /* Sidebar */
        .sidebar {
            width: 300px;
            /* original width */
            min-height: 100vh;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            padding: 0.5rem;
            font-family: 'Montserrat', sans-serif;
        }

        .sidebar .nav-link {
            color: gray;
            font-size: 0.90rem;
            /* smaller text */
            padding: 0.25rem 0.5rem;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link i {
            margin-right: 1rem;
        }

        .sidebar .nav-link:hover {
            background-color: #e9ecef;
            color: black;
        }
    

        /* Top Navbar */
        .top-navbar {
            height: 50px;
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 1rem;
            font-family: 'Montserrat', sans-serif;
        }

        /* Profile Dropup */
        .profile-btn {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.2rem 0.4rem;
            border: none;
            background: transparent;
            font-size: 0.9rem;
        }

        .profile-btn img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Main page content */
        .page-content {
            padding: 1.5rem;
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column">
            <h5 class="mb-3 text-center">BoardMate</h5>

            <!-- Small Platform Label -->
            <div class="text-muted mt-3 small mb-2 ps-2">
                Platform
            </div>

            <ul class="nav nav-pills flex-column fw-medium gap-2">
                <li class="nav-item mb-1">
                    <a href="#" class="nav-link"><i class="bi bi-house-door"></i> Properties</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="nav-link"><i class="bi bi-geo-alt"></i> Location</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="nav-link"><i class="bi bi-building"></i> Be a Renter</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="nav-link"><i class="bi bi-chat-left-text"></i> Messages</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="nav-link"><i class="bi bi-bell"></i> Notifications</a>
                </li>
            </ul>


            <!-- Profile Dropup at Bottom -->
            <div class="dropup mt-auto">
                <button class="btn profile-btn dropdown-toggle p-2 w-100 d-flex align-items-center justify-content-between border fw-semibold text-secondary"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <img src="{{ auth()->user()->avatar 
          ? asset('storage/' . auth()->user()->avatar) 
          : asset('images/default-avatar.png') }}"
                            alt="Profile Image" class="me-2 shadow">
                        <span>{{ auth()->user()->firstname }}</span>
                    </div>
                </button>


                <ul class="dropdown-menu w-100">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <img src="{{ auth()->user()->avatar 
                                      ? asset('storage/' . auth()->user()->avatar) 
                                      : asset('images/default-avatar.png') }}"
                                alt="Profile Image"
                                class="rounded-circle me-2 shadow-sm"
                                width="36" height="36">

                            <div class="d-flex flex-column">
                                <span class="fw-semibold">{{ auth()->user()->firstname }}</span>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="bi bi-gear me-2"></i> <small>Settings</small>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item  d-flex align-items-center" href="#">
                            <i class="bi bi-box-arrow-right me-2"></i> <small>Logout</small>
                        </a>
                    </li>
                </ul>

            </div>

        </div>


        <!-- Main Content -->
        <div class="content" style="width: 100%;">
            <!-- Top Navbar -->
            <div class="top-navbar">
                <!-- Profile Dropup -->

            </div>

            <!-- Page Content -->
            <div class="page-content">
                <h1>Welcome to BoardMate</h1>
                <p>This is the main content area.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>