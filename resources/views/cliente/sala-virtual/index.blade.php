<x-cliente-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-video mr-2"></i>
            Sala Virtual
        </h2>
    </x-slot>
    @section('page-title', 'Sala Virtual')

    <div class="py-6">
        <div class="bg-white rounded-lg shadow-md p-8 text-center text-gray-600">
            <i class="fas fa-video text-4xl mb-4"></i>
            <p>Acceso a transmisiones en vivo de velaciones cuando tengas un servicio programado.</p>
            <p class="text-sm mt-2">Cuando tengas una velación virtual asignada, el enlace aparecerá aquí.</p>
        </div>
    </div>
</x-cliente-layout>
