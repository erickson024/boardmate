<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'Boardmate' }}</title>
</head>

<body>
    <!-- Google Maps API -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps.key') }}&libraries=places"
        defer>
    </script>


    <nav>
        @if(
        !Route::is('register') &&
        !Route::is('login') &&
        !Route::is('password.request') &&
        !Route::is('password.reset') &&
        !Route::is('admin.dashboard') &&
        !Route::is('host.request') &&
        !Route::is('host.welcome') &&
        !Route::is('property-registration')
        )
        <x-navigation />
        @endif
    </nav>

    <main>
        {{ $slot }}
        <x-boardmate-toast />
    </main>


    <!-- Password toggle script -->
    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye-fill");
                icon.classList.add("bi-eye-slash-fill");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-slash-fill");
                icon.classList.add("bi-eye-fill");
            }
        }
    </script>

</body>

</html>