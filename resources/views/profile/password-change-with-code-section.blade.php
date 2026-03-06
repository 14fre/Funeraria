<x-action-section>
    <x-slot name="title">Cambiar contraseña con código por correo</x-slot>
    <x-slot name="description">Solicite un código a su correo y úselo para confirmar el cambio de contraseña.</x-slot>

    <x-slot name="content">
        @if (session('status') === 'password-change-code-sent')
            <p class="text-sm text-green-600 mb-4">Se ha enviado un código de 6 dígitos a {{ Auth::user()->email }}. Revise su bandeja e ingréselo abajo junto con su nueva contraseña.</p>
        @endif
        @if (session('status') === 'password-changed')
            <p class="text-sm text-green-600 mb-4">Contraseña cambiada correctamente.</p>
        @endif

        <div class="space-y-4">
            @if (!session('status') || session('status') === 'password-changed')
                <form method="POST" action="{{ route('password-change.send-code') }}" class="inline">
                    @csrf
                    <x-button type="submit">Enviar código a mi correo</x-button>
                </form>
            @endif

            @if (session('status') === 'password-change-code-sent')
                <form method="POST" action="{{ route('password-change.with-code') }}" class="space-y-4 max-w-md">
                    @csrf
                    <div>
                        <x-label for="code" value="Código recibido por correo" />
                        <x-input id="code" name="code" type="text" class="block w-full mt-1" placeholder="000000" maxlength="6" pattern="[0-9]{6}" required autocomplete="one-time-code" />
                        <x-input-error for="code" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="current_password_code" value="Contraseña actual" />
                        <x-input id="current_password_code" name="current_password" type="password" class="block w-full mt-1" required autocomplete="current-password" />
                        <x-input-error for="current_password" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="password_code" value="Nueva contraseña" />
                        <x-input id="password_code" name="password" type="password" class="block w-full mt-1" required autocomplete="new-password" />
                        <x-input-error for="password" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="password_confirmation_code" value="Confirmar contraseña" />
                        <x-input id="password_confirmation_code" name="password_confirmation" type="password" class="block w-full mt-1" required autocomplete="new-password" />
                    </div>
                    <x-button type="submit">Cambiar contraseña</x-button>
                </form>
            @endif
        </div>
    </x-slot>
</x-action-section>
