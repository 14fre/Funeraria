<x-cliente-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-hand-holding-heart mr-2"></i>
            Mis Servicios
        </h2>
    </x-slot>
    @section('page-title', 'Servicios')

    <div class="py-6">
        @if (!$afiliado)
            <div class="bg-white rounded-lg shadow-md p-8 text-center text-gray-600">
                <p>No tienes un plan asignado. Contacta con la funeraria para solicitar servicios.</p>
                <a href="{{ route('cliente.dashboard') }}" class="inline-block mt-4 text-red-600 hover:text-red-700 font-medium">Volver al dashboard</a>
            </div>
        @else
            <div class="mb-4">
                <a href="{{ route('cliente.servicios.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i>Solicitar servicio
                </a>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @php
                    $estados = ['solicitado' => 'Solicitado', 'programado' => 'Programado', 'en_proceso' => 'En proceso', 'completado' => 'Completado', 'cancelado' => 'Cancelado'];
                    $tipos = ['velacion' => 'Velación', 'velacion_virtual' => 'Velación Virtual', 'cremacion' => 'Cremación', 'traslado_nacional' => 'Traslado Nacional', 'traslado_internacional' => 'Traslado Internacional'];
                @endphp
                @if ($servicios->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha solicitud</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha servicio</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($servicios as $s)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $tipos[$s->tipo] ?? $s->tipo }}</td>
                                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full @if($s->estado==='completado') bg-green-100 text-green-800 @elseif($s->estado==='cancelado') bg-red-100 text-red-800 @else bg-yellow-100 text-yellow-800 @endif">{{ $estados[$s->estado] ?? $s->estado }}</span></td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $s->fecha_solicitud->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $s->fecha_servicio ? $s->fecha_servicio->format('d/m/Y') : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-8 text-center text-gray-500">
                        <i class="fas fa-hand-holding-heart text-4xl mb-3"></i>
                        <p>No tienes servicios solicitados.</p>
                        <a href="{{ route('cliente.servicios.create') }}" class="inline-block mt-3 text-red-600 hover:text-red-700 font-medium">Solicitar servicio</a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-cliente-layout>
