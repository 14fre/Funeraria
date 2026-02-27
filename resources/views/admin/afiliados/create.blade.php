<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-user-plus mr-2"></i>
            Nuevo Afiliado
        </h2>
    </x-slot>

    <div class="py-6">
        @livewire('admin.afiliados.create')
    </div>
</x-admin-layout>
