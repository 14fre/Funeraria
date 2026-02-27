<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-user-edit mr-2"></i>
            Editar Usuario
        </h2>
    </x-slot>

    @section('page-title', 'Editar Usuario')

    <div class="py-6">
        @livewire('admin.usuarios.edit', ['user' => $user])
    </div>
</x-admin-layout>

