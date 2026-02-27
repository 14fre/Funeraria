<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-users mr-2"></i>
            Gestión de Usuarios
        </h2>
    </x-slot>

    @section('page-title', 'Gestión de Usuarios')

    <div class="py-6">
        @livewire('admin.usuarios.index')
    </div>
</x-admin-layout>

