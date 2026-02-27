<x-cliente-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-money-bill-wave mr-2"></i>
            Mis Pagos
        </h2>
    </x-slot>
    @section('page-title', 'Pagos')

    <div class="py-6">
        @if (!$afiliado)
            <div class="bg-white rounded-lg shadow-md p-8 text-center text-gray-600">
                <p>No tienes un plan asignado. Contacta con la funeraria para afiliarte y realizar pagos.</p>
                <a href="{{ route('cliente.dashboard') }}" class="inline-block mt-4 text-red-600 hover:text-red-700 font-medium">Volver al dashboard</a>
            </div>
        @else
            <div class="mb-4">
                <a href="{{ route('cliente.pagos.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i>Realizar pago
                </a>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @php $estados = ['pendiente' => 'Pendiente', 'aprobado' => 'Aprobado', 'rechazado' => 'Rechazado', 'anulado' => 'Anulado']; @endphp
                @if ($pagos->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Referencia</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($pagos as $p)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $p->fecha_pago ? $p->fecha_pago->format('d/m/Y') : '—' }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">${{ number_format($p->monto, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full @if($p->estado==='aprobado') bg-green-100 text-green-800 @elseif($p->estado==='pendiente') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">{{ $estados[$p->estado] ?? $p->estado }}</span></td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $p->referencia ?? $p->numero_recibo ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="bg-gray-50 px-4 py-3 border-t">{{ $pagos->links() }}</div>
                @else
                    <div class="p-8 text-center text-gray-500">
                        <i class="fas fa-money-bill-wave text-4xl mb-3"></i>
                        <p>No hay pagos registrados.</p>
                        <a href="{{ route('cliente.pagos.create') }}" class="inline-block mt-3 text-green-600 hover:text-green-700 font-medium">Realizar un pago</a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-cliente-layout>
