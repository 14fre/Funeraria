<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-users mr-2"></i>
            Gestión de Afiliados
        </h2>
    </x-slot>

    <div class="py-6">
        @livewire('admin.afiliados.index')
    </div>
</x-admin-layout>
