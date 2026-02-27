<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-user-edit mr-2"></i>Editar Beneficiario
        </h2>
    </x-slot>
    <div class="py-6">@livewire('admin.beneficiarios.edit', ['beneficiario' => $beneficiario])</div>
</x-admin-layout>
