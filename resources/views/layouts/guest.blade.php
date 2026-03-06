@props(['title' => 'Acceso'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('images/icono.ico') }}">
        <link rel="icon" type="image/png" href="{{ asset('images/icono.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/icono.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/public.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <a href="{{ route('home') }}" class="back-float" id="back-float" aria-label="Volver" title="Volver">
            <i class="fas fa-arrow-left"></i>
            <span class="back-float__text">Volver</span>
        </a>

        <div class="auth-page-funeraria" role="main">
            <div class="auth-page-funeraria__bg" aria-hidden="true"></div>
            <div class="auth-page-funeraria__overlay" aria-hidden="true"></div>
            <div class="auth-page-funeraria__content">
                {{ $slot }}
            </div>
        </div>

        <footer class="auth-footer text-center py-4 text-sm text-white/80">
            <p>Funeraria San José &copy; {{ date('Y') }}</p>
        </footer>

        @livewireScripts
        <script>
        (function() {
            var back = document.getElementById('back-float');
            if (!back) return;
            back.addEventListener('click', function(e) {
                if (window.history.length > 1) {
                    e.preventDefault();
                    window.history.back();
                }
            });
        })();
        </script>
    </body>
</html>
