<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Panel Administrativo')</title>

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
        /* Scrollbar del menú admin: discreta y acorde al tema vinotinto/dorado */
        .admin-sidebar-nav::-webkit-scrollbar { width: 6px; }
        .admin-sidebar-nav::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); border-radius: 3px; }
        .admin-sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,215,0,0.35); border-radius: 3px; }
        .admin-sidebar-nav::-webkit-scrollbar-thumb:hover { background: rgba(255,215,0,0.5); }
        .admin-sidebar-nav { scrollbar-width: thin; scrollbar-color: rgba(255,215,0,0.4) rgba(0,0,0,0.2); }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-banner />

    <div class="min-h-screen flex">
        <!-- Sidebar Mobile Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>
        
        <!-- Sidebar (colores marca: vinotinto / dorado) -->
        <aside id="sidebar" class="w-64 bg-gradient-to-b from-[#5C0E2B] to-[#1A1A1A] text-white min-h-screen fixed left-0 top-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 lg:block">
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
                
                <nav class="space-y-2 overflow-y-auto max-h-[calc(100vh-8rem)] pr-1 admin-sidebar-nav">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.usuarios.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.usuarios.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-users w-5 mr-3"></i>
                        Usuarios
                    </a>
                    
                    <a href="{{ route('admin.solicitudes-afiliacion.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.solicitudes-afiliacion.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-inbox w-5 mr-3"></i>
                        Solicitudes de afiliación
                    </a>
                    
                    <a href="{{ route('admin.afiliados.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.afiliados.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-user-friends w-5 mr-3"></i>
                        Afiliados
                    </a>
                    
                    <a href="{{ route('admin.beneficiarios.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.beneficiarios.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-user-tag w-5 mr-3"></i>
                        Beneficiarios
                    </a>
                    
                    <a href="{{ route('admin.planes.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.planes.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-file-contract w-5 mr-3"></i>
                        Planes Exequiales
                    </a>
                    
                    <a href="{{ route('admin.servicios.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.servicios.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-hand-holding-heart w-5 mr-3"></i>
                        Servicios
                    </a>
                    
                    <a href="{{ route('admin.pagos.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.pagos.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-money-bill-wave w-5 mr-3"></i>
                        Pagos
                    </a>
                    
                    <a href="{{ route('admin.inventario.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.inventario.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-boxes w-5 mr-3"></i>
                        Inventario
                    </a>
                    
                    <a href="{{ route('admin.vehiculos.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.vehiculos.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-car w-5 mr-3"></i>
                        Vehículos
                    </a>
                    
                    <a href="{{ route('admin.salas.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.salas.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-door-open w-5 mr-3"></i>
                        Salas
                    </a>
                    
                    <a href="{{ route('admin.reservas.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.reservas.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-calendar-check w-5 mr-3"></i>
                        Reservas
                    </a>
                    
                    <a href="{{ route('admin.obituarios.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.obituarios.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-book w-5 mr-3"></i>
                        Obituarios
                    </a>
                    
                    <a href="{{ route('admin.contabilidad.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.contabilidad.*') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-chart-line w-5 mr-3"></i>
                        Finanzas
                    </a>
                    
                    <a href="{{ route('admin.perfil') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.perfil') ? 'bg-[#FFD700] text-gray-900 font-semibold' : 'hover:bg-[#7a1a3d]' }}">
                        <i class="fas fa-user w-5 mr-3"></i>
                        Mi Perfil
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <button id="open-sidebar" class="lg:hidden text-gray-600 hover:text-gray-800">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h2 class="text-xl font-semibold text-gray-800">
                            @yield('page-title', 'Panel Administrativo')
                        </h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrador</p>
                        </div>
                        
                        @php
                            $u = Auth::user();
                            $avatarSrc = $u->profile_photo_path
                                ? asset('storage/' . $u->profile_photo_path) . '?v=' . ($u->updated_at?->timestamp ?? time())
                                : $u->profile_photo_url;
                            $avatarFallback = 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&color=5C0E2B&background=EBF4FF';
                        @endphp
                        <div class="relative">
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
            <main class="p-6 flex flex-col min-h-[calc(100vh-4rem)]">
                @if (isset($header))
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endif

                <div class="flex-1">
                    {{ $slot }}
                </div>

                <footer class="mt-8 pt-6 border-t border-gray-200 text-center text-sm text-gray-500">
                    <p>Funeraria San José &copy; {{ date('Y') }}. Panel administrativo.</p>
                    <p class="mt-1">Sistema de gestión exequial.</p>
                </footer>
            </main>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
    @include('partials.flash-sweetalert')
    @stack('scripts')
    
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

