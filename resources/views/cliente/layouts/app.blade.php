<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Mi Portal')</title>

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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Fondo fijo en área de contenido (portal cliente): gris medio profesional + watermark */
        .cliente-portal-bg {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 0;
            background: linear-gradient(165deg, #c8cad0 0%, #bcc0c7 30%, #b4b8bf 60%, #ccced4 100%);
            background-attachment: fixed;
        }
        @media (min-width: 1024px) {
            .cliente-portal-bg { left: 16rem; }
        }
        .cliente-portal-watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 20rem;
            color: #5C0E2B;
            opacity: 0.08;
            pointer-events: none;
            z-index: 0;
        }
        @media (min-width: 1024px) {
            .cliente-portal-watermark { left: calc(8rem + (100vw - 16rem) / 2); }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <x-banner />

    <div class="min-h-screen flex">
        <!-- Sidebar Mobile Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>
        
        <!-- Sidebar (vinotinto / dorado, sin rojo vivo) -->
        <aside id="sidebar" class="w-64 bg-gradient-to-b from-[#5C0E2B] to-[#3d0a1e] text-white min-h-screen fixed left-0 top-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 lg:block">
            <div class="p-6">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-2xl font-bold text-[#FFD700]">
                        <i class="fas fa-cross mr-2"></i>
                        Funeraria San José
                    </h1>
                    <button id="close-sidebar" class="lg:hidden text-white hover:text-[#FFD700]">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <nav class="space-y-1">
                    <a href="{{ route('cliente.dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('cliente.dashboard') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('cliente.plan.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('cliente.plan.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-file-contract w-5 mr-3"></i>
                        Mi Plan
                    </a>
                    
                    <a href="{{ route('cliente.beneficiarios.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('cliente.beneficiarios.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-user-friends w-5 mr-3"></i>
                        Beneficiarios
                    </a>
                    
                    <a href="{{ route('cliente.servicios.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('cliente.servicios.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-hand-holding-heart w-5 mr-3"></i>
                        Servicios
                    </a>
                    
                    <a href="{{ route('cliente.pagos.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('cliente.pagos.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-money-bill-wave w-5 mr-3"></i>
                        Pagos
                    </a>
                    
                    <a href="{{ route('cliente.obituarios.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('cliente.obituarios.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-book w-5 mr-3"></i>
                        Obituarios
                    </a>
                    
                    <a href="{{ route('cliente.sala-virtual.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('cliente.sala-virtual.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-video w-5 mr-3"></i>
                        Sala Virtual
                    </a>
                    
                    <a href="{{ route('cliente.perfil') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('cliente.perfil') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-user-circle w-5 mr-3"></i>
                        Mi Perfil
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content (fondo fijo sutil + watermark discreto) -->
        <div class="cliente-portal-wrap flex-1 lg:ml-64 relative min-h-screen">
            <div class="cliente-portal-bg" aria-hidden="true"></div>
            <div class="cliente-portal-watermark" aria-hidden="true"><i class="fas fa-cross"></i></div>

            <!-- Top Navigation -->
            <header class="cliente-portal-header bg-white/95 backdrop-blur-sm shadow-sm border-b border-gray-200 sticky top-0 z-20">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <button id="open-sidebar" class="lg:hidden text-gray-600 hover:text-gray-800">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h2 class="text-xl font-semibold text-gray-800">
                            {{ $pageTitle ?? 'Mi Portal' }}
                        </h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Cliente</p>
                        </div>
                        
                        @php
                            $u = Auth::user();
                            $avatarSrc = $u->profile_photo_path
                                ? asset('storage/' . $u->profile_photo_path)
                                : $u->profile_photo_url;
                            $avatarFallback = 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&color=7F9CF5&background=EBF4FF';
                        @endphp
                        <div class="relative flex-shrink-0">
                            <img src="{{ $avatarSrc }}"
                                 alt="{{ $u->name }}"
                                 class="w-10 h-10 rounded-full border-2 border-[#FFD700] object-cover bg-gray-200"
                                 onerror="this.onerror=null; this.src='{{ $avatarFallback }}';">
                        </div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="text-gray-600 hover:text-[#5C0E2B] transition-colors p-2 rounded-lg hover:bg-gray-100"
                                    title="Cerrar sesión">
                                <i class="fas fa-sign-out-alt text-lg"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="cliente-portal-main relative z-10 p-6">
                @if (isset($header))
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
    @include('partials.flash-sweetalert')
    
    <script>
        // Toggle sidebar en móvil
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const openBtn = document.getElementById('open-sidebar');
            const closeBtn = document.getElementById('close-sidebar');
            
            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }
            
            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
            
            if (openBtn) {
                openBtn.addEventListener('click', openSidebar);
            }
            
            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebar);
            }
            
            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }
        });
    </script>
</body>
</html>

