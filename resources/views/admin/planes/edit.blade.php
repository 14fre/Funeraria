<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-edit mr-2"></i>
            Editar Plan Exequial
        </h2>
    </x-slot>

    @section('page-title', 'Editar Plan')

    <div class="py-6">
        @livewire('admin.planes.edit', ['plan' => $plan])
    </div>
</x-admin-layout>

