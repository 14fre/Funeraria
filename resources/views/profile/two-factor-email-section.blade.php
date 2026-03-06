<x-action-section>
    <x-slot name="title">Verificación en dos pasos por correo</x-slot>
    <x-slot name="description">Recibir un código en su correo al iniciar sesión.</x-slot>

    <x-slot name="content">
        @if (session('status') === 'two-factor-email-enabled')
            <p class="text-sm text-green-600 mb-4">Verificación por correo activada. En el próximo inicio de sesión recibirá un código en {{ Auth::user()->email }}.</p>
        @endif
        @if (session('status') === 'two-factor-email-disabled')
            <p class="text-sm text-gray-600 mb-4">Verificación por correo desactivada.</p>
        @endif

        @if (Auth::user()->two_factor_via_email)
            <p class="text-sm text-gray-600 mb-4">La verificación en dos pasos por correo está activa. Cada vez que inicie sesión se enviará un código a su correo registrado.</p>
            <div x-data="{ showModal: false }">
                <x-danger-button type="button" @click="showModal = true">Desactivar verificación por correo</x-danger-button>
                <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
                    <div class="flex min-h-screen items-end sm:items-center justify-center p-4">
                        <div x-show="showModal" class="fixed inset-0 bg-black/50 transition-opacity" @click="showModal = false"></div>
                        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Desactivar verificación por correo</h3>
                            <p class="text-sm text-gray-600 mb-4">Escriba su contraseña para confirmar.</p>
                            <form method="POST" action="{{ route('two-factor-email.disable') }}">
                                @csrf
                                <x-input type="password" name="password" class="block w-full mb-4" placeholder="Contraseña" required autocomplete="current-password" />
                                @error('password')
                                    <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                                @enderror
                                <div class="flex gap-2 justify-end">
                                    <x-secondary-button type="button" @click="showModal = false">Cancelar</x-secondary-button>
                                    <x-danger-button type="submit">Desactivar</x-danger-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <p class="text-sm text-gray-600 mb-4">Al activar, cada vez que inicie sesión se enviará un código de 6 dígitos a su correo registrado. Deberá ingresarlo para continuar.</p>
            <div x-data="{ showModal: false }">
                <x-button type="button" @click="showModal = true">Activar verificación por correo</x-button>
                <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
                    <div class="flex min-h-screen items-end sm:items-center justify-center p-4">
                        <div x-show="showModal" class="fixed inset-0 bg-black/50 transition-opacity" @click="showModal = false"></div>
                        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Activar verificación por correo</h3>
                            <p class="text-sm text-gray-600 mb-4">Escriba su contraseña para confirmar.</p>
                            <form method="POST" action="{{ route('two-factor-email.enable') }}">
                                @csrf
                                <x-input type="password" name="password" class="block w-full mb-4" placeholder="Contraseña" required autocomplete="current-password" />
                                @error('password')
                                    <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                                @enderror
                                <div class="flex gap-2 justify-end">
                                    <x-secondary-button type="button" @click="showModal = false">Cancelar</x-secondary-button>
                                    <x-button type="submit">Activar</x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </x-slot>
</x-action-section>
