<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Funeraria San José')</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('images/icono.ico') }}">
        <link rel="icon" type="image/png" href="{{ asset('images/icono.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/icono.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex flex-col min-h-[calc(100vh-8rem)]">
                <div class="flex-1">
                    {{ $slot }}
                </div>
                <footer class="mt-auto py-4 border-t border-gray-200 bg-white text-center text-sm text-gray-500">
                    <p>Funeraria San José &copy; {{ date('Y') }}. Sistema de gestión exequial.</p>
                </footer>
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
