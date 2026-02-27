<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-file-contract mr-2"></i>
            Gestión de Planes Exequiales
        </h2>
    </x-slot>

    @section('page-title', 'Planes Exequiales')

    <div class="py-6">
        @livewire('admin.planes.index')
    </div>
</x-admin-layout>

