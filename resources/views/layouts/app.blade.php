<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo2.png') }}">

    <!--font link-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!--icon link-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <title>@yield('title', 'Boardmate')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <!-- Google Maps API -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places"
        async
        defer>
    </script>

    @guest
    {{-- Show top navbar for guests --}}
    @include('layouts.partials.navbar')
    <main class="container-fluid">
        <div class="row">
            <div class="col-12" style="margin-top: 6%;">
                @yield('content')
            </div>
        </div>
    </main>
    @endguest

    @auth
    @include('layouts.partials.navbar')
    <div class="container-fluid">
        <div class="row" style="margin-top: 6%;">
            <div class="col-12">
                @yield('content')
            </div>
        </div>
    </div>
    @endauth

    @livewireScripts
</body>

</html>