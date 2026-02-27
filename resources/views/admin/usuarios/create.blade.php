<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-user-plus mr-2"></i>
            Crear Usuario
        </h2>
    </x-slot>

    @section('page-title', 'Crear Usuario')

    <div class="py-6">
        @livewire('admin.usuarios.create')
    </div>
</x-admin-layout>

