<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo2.png') }}">

    <!--font link-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!--icon link-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <title>@yield('title', 'Boardmate')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles

    <title>{{ $title ?? 'Page Title' }}</title>
</head>

<body class="vh-100">
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places" >
    </script>
    
     @if (!request()->routeIs('signup') && !request()->routeIs('login') && !request()->routeIs('password.request') && !request()->routeIs('password.reset'))
        @include('layouts.partials.navbar')
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>