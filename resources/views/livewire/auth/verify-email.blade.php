<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <!--font link-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!--icon link-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-11 col-md-8 col-lg-5">
            <div class="p-4 rounded-4 shadow-sm border bg-white text-center">
                <p class="fs-6 mb-4">
                    Thanks for signing up! Before getting started, please verify your email by clicking the link we just sent to your inbox.
                </p>

                <div class="row gx-2">
                    <div class="col-8">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-dark w-100">
                                Resend Verification Email
                            </button>
                        </form>
                    </div>

                    <div class="col-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-dark w-100">
                                Later
                            </button>
                        </form>
                    </div>


                </div>

                @if (session('message'))
                <div class="alert alert-success mt-3 py-1 mb-4">
                    {{ session('message') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>