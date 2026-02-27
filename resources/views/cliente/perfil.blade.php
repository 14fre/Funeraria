<x-cliente-layout>
    <x-slot name="pageTitle">Mi Perfil</x-slot>

    <div class="perfil-page max-w-4xl mx-auto py-6">
        <div class="text-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800 tracking-tight" style="font-family: 'Cormorant Garamond', serif;">Mi Perfil</h1>
            <p class="text-gray-500 mt-1 text-sm">Tu información y foto.</p>
        </div>

        {{-- Tarjeta principal: foto de perfil destacada --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
            <div class="perfil-hero bg-gradient-to-br from-[#5C0E2B]/5 to-[#3d0a1e]/10 px-6 py-8 sm:py-10">
                <div class="flex flex-col sm:flex-row items-center gap-6 sm:gap-8">
                    <div class="relative flex-shrink-0">
                        @php
                                $u = Auth::user();
                                $photoSrc = $u->profile_photo_path ? asset('storage/' . $u->profile_photo_path) : $u->profile_photo_url;
                                $photoFallback = 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&color=5C0E2B&background=EBF4FF&size=160';
                            @endphp
                            <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-full ring-4 ring-[#FFD700]/30 ring-offset-2 ring-offset-white overflow-hidden bg-gray-100 shadow-inner">
                                <img src="{{ $photoSrc }}"
                                     alt="{{ $u->name }}"
                                     class="w-full h-full object-cover"
                                     onerror="this.onerror=null; this.src='{{ $photoFallback }}';">
                            </div>
                        <div class="absolute bottom-0 right-0 w-10 h-10 rounded-full bg-[#5C0E2B] flex items-center justify-center shadow-md" title="Foto de perfil">
                            <i class="fas fa-user text-[#FFD700] text-sm"></i>
                        </div>
                    </div>
                    <div class="text-center sm:text-left flex-1">
                        <h2 class="text-xl font-semibold text-gray-800" style="font-family: 'Cormorant Garamond', serif;">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-500 text-sm mt-0.5">{{ Auth::user()->email }}</p>
                        <p class="text-[#5C0E2B] text-xs mt-2">Edita abajo.</p>
                    </div>
                </div>
            </div>

            {{-- Formulario de información (foto, nombre, email) --}}
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <div class="px-6 py-6 border-t border-gray-100">
                    @livewire('profile.update-profile-information-form')
                </div>
            @endif
        </div>

        {{-- Contraseña --}}
        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
                @livewire('profile.update-password-form')
            </div>
        @endif

        {{-- Autenticación en dos pasos (si está habilitada) --}}
        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
                @livewire('profile.two-factor-authentication-form')
            </div>
        @endif

        {{-- Sesiones de otros navegadores --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>

        {{-- Eliminar cuenta --}}
        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                @livewire('profile.delete-user-form')
            </div>
        @endif
    </div>

    {{-- Fuente elegante solo para esta página --}}
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

    <style>
        .perfil-page .md\:grid { max-width: 100%; }
        .perfil-page .rounded-md { border-radius: 0.75rem; }
        .perfil-page input:focus, .perfil-page button:focus { --tw-ring-color: rgba(92, 14, 43, 0.35); }
        .perfil-page [wire\:target]:disabled { opacity: 0.7; }
    </style>
</x-cliente-layout>
