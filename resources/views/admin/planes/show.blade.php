<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-file-contract mr-2"></i>
            Detalles del Plan
        </h2>
    </x-slot>

    @section('page-title', 'Detalles del Plan')

    <div class="py-6">
        @livewire('admin.planes.show', ['plan' => $plan])
    </div>
</x-admin-layout>

