<x-admin-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight"><i class="fas fa-edit mr-2"></i>Editar Servicio</h2></x-slot>
    <div class="py-6">@livewire('admin.servicios.edit', ['servicio' => $servicio])</div>
</x-admin-layout>
