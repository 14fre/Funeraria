<x-cliente-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-credit-card mr-2"></i>
            Realizar Pago
        </h2>
    </x-slot>
    @section('page-title', 'Realizar Pago')

    <div class="py-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-xl">
            <p class="text-gray-600 mb-4">Plan: <strong>{{ $afiliado->planExequial->nombre }}</strong>. Próximo pago sugerido según tu plan.</p>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                <p class="text-gray-700">La integración con Wompi / Bancolombia / Nequi estará disponible próximamente.</p>
                <p class="text-sm text-gray-600 mt-2">Por ahora puedes acercarte a la funeraria o contactar para realizar tu pago.</p>
            </div>
            <div class="mt-6">
                <a href="{{ route('cliente.pagos.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium">Volver a pagos</a>
            </div>
        </div>
    </div>
</x-cliente-layout>
