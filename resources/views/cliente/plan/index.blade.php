<x-cliente-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-file-contract mr-2"></i>
            Mi Plan
        </h2>
    </x-slot>
    @section('page-title', 'Mi Plan')

    <div class="py-6">
        @if ($afiliado && $plan)
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $plan->nombre }}</h3>
                <p class="text-gray-600 text-sm mb-2">{{ $plan->descripcion }}</p>
                <p class="text-gray-700"><strong>Estado afiliación:</strong> {{ $afiliado->estado }}</p>
                <p class="text-gray-700"><strong>Nº afiliación:</strong> {{ $afiliado->numero_afiliacion }}</p>
                <p class="text-gray-700"><strong>Fecha afiliación:</strong> {{ $afiliado->fecha_afiliacion->format('d/m/Y') }}</p>
                <p class="text-gray-700"><strong>Máx. beneficiarios:</strong> {{ $plan->max_beneficiarios }}</p>
                <p class="text-gray-700 mt-2"><strong>Precio mensual:</strong> ${{ number_format($plan->precio_mensual, 0, ',', '.') }} COP</p>
                <p class="text-gray-700"><strong>Precio anual:</strong> ${{ number_format($plan->precio_anual, 0, ',', '.') }} COP</p>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="text-center mb-6">
                    <i class="fas fa-file-contract text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg">Sin plan asignado</p>
                    <p class="text-gray-500 text-sm mt-2">Solicita tu afiliación a un plan exequial y un administrador la revisará.</p>
                </div>
                @if ($solicitudPendiente ?? null)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                        <p class="text-yellow-800 font-medium">Tienes una solicitud en proceso</p>
                        <p class="text-yellow-700 text-sm mt-1">Plan solicitado: <strong>{{ $solicitudPendiente->planExequial->nombre }}</strong></p>
                        <p class="text-yellow-600 text-xs mt-1">Enviada el {{ $solicitudPendiente->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                @else
                    <div class="text-center">
                        <a href="{{ route('cliente.solicitar-afiliacion') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium">
                            <i class="fas fa-paper-plane mr-2"></i>Solicitar afiliación a un plan
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-cliente-layout>
