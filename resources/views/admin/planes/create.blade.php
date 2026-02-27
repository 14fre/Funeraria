<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-plus-circle mr-2"></i>
            Crear Plan Exequial
        </h2>
    </x-slot>

    @section('page-title', 'Crear Plan')

    <div class="py-6">
        @livewire('admin.planes.create')
    </div>
</x-admin-layout>

