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
    <!--update the page if the user successfully verified his account-->
    @if (auth()->user()->hasVerifiedEmail())
    <script>
        window.location.href = "{{ route('propertyList') }}";
    </script>
    @endif

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-11 col-md-8 col-lg-5">
            <div class="d-flex justify-content-center mb-2">
                <x-logo-dark style="width:40px;" />
                <div class="fs-6 fw-medium d-flex align-items-center">Boardmate</div>
            </div>

            <div class="p-4 rounded-4 shadow-sm border bg-white text-center">
                <div class="mb-3">
                    <img src="{{ asset('images/gif1.gif') }}" alt="Verification GIF" class="img-fluid" style="max-height:150px;">
                </div>
                <p class="fs-6 mb-4">
                    Thanks for signing up! Before getting started, please verify your email by clicking the link we just sent to your inbox.
                </p>

                <div class="row gx-2">
                    <div class="col-4">
                        <form method="POST" action="{{route('logout')}}">
                            @csrf
                            <x-buttons.small-button type="submit" class="w-100">
                                    <span><i class="bi bi-arrow-left-short"></i></span>
                                    <span>Verify later</span>
                            </x-buttons.small-button>
                        </form>
                    </div>

                    <div class="col-8">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <x-buttons.small-button class="w-100">
                                Resend Verification Email
                                </x-button-small-button>
                        </form>
                    </div>


                </div>

                @if (session('message'))
                <div class="alert alert-primary mt-3 py-1 mb-2">
                    <small>{{ session('message') }}</small>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>