<x-action-section>
    <x-slot name="title">Eliminar cuenta</x-slot>
    <x-slot name="description">Eliminación permanente.</x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            Se borrarán todos tus datos. Descarga lo que quieras conservar antes.
        </div>
        <div class="mt-5">
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">Eliminar cuenta</x-danger-button>
        </div>

        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">Eliminar cuenta</x-slot>
            <x-slot name="content">
                ¿Estás seguro? Esta acción no se puede deshacer. Escribe tu contraseña para confirmar.
                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="mt-1 block w-3/4"
                                autocomplete="current-password"
                                placeholder="Contraseña"
                                x-ref="password"
                                wire:model="password"
                                wire:keydown.enter="deleteUser" />
                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">Cancelar</x-secondary-button>
                <x-danger-button class="ms-3" wire:click="deleteUser" wire:loading.attr="disabled">Eliminar cuenta</x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
