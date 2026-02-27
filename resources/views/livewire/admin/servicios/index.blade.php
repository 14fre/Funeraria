<div>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800"><i class="fas fa-hand-holding-heart mr-2"></i>Servicios Funerarios</h2>
        <a href="{{ route('admin.servicios.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Nuevo Servicio</a>
    </div>
    @if (session('success'))<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>@endif
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500"><p class="text-gray-600 text-sm">Total</p><p class="text-xl font-bold">{{ $stats['total'] }}</p></div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500"><p class="text-gray-600 text-sm">Solicitados</p><p class="text-xl font-bold">{{ $stats['solicitado'] }}</p></div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500"><p class="text-gray-600 text-sm">Completados</p><p class="text-xl font-bold">{{ $stats['completado'] }}</p></div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-red-500"><p class="text-gray-600 text-sm">Cancelados</p><p class="text-xl font-bold">{{ $stats['cancelado'] }}</p></div>
    </div>
    <div class="bg-white rounded-lg shadow-md p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div><label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label><input type="text" wire:model.live.debounce.300ms="search" placeholder="Afiliado..." class="w-full px-3 py-2 border rounded-lg"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label><select wire:model.live="tipoFilter" class="w-full px-3 py-2 border rounded-lg"><option value="">Todos</option>@foreach($tipos as $k=>$v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-2">Estado</label><select wire:model.live="estadoFilter" class="w-full px-3 py-2 border rounded-lg"><option value="">Todos</option>@foreach($estados as $k=>$v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-2">Por página</label><select wire:model.live="perPage" class="w-full px-3 py-2 border rounded-lg"><option value="10">10</option><option value="25">25</option><option value="50">50</option></select></div>
    </div>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50"><tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Afiliado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha solicitud</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha servicio</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($servicios as $s)
                    <tr class="hover:bg-gray-50" wire:key="servicio-{{ $s->id }}">
                        <td class="px-6 py-4 text-sm">{{ $s->afiliado->numero_afiliacion ?? '—' }} {{ $s->afiliado->user->name ?? '' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $tipos[$s->tipo] ?? $s->tipo }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full @if($s->estado==='completado') bg-green-100 text-green-800 @elseif($s->estado==='cancelado') bg-red-100 text-red-800 @else bg-yellow-100 text-yellow-800 @endif">{{ $estados[$s->estado] ?? $s->estado }}</span></td>
                        <td class="px-6 py-4 text-sm">{{ $s->fecha_solicitud->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm">{{ $s->fecha_servicio ? $s->fecha_servicio->format('d/m/Y') : '—' }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('admin.servicios.edit', $s) }}" class="text-yellow-600 hover:text-yellow-900 mr-3"><i class="fas fa-edit"></i></a>
                            <button wire:click="delete({{ $s->id }})" wire:confirm="¿Eliminar este servicio?" wire:loading.attr="disabled" wire:target="delete" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay servicios.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="bg-gray-50 px-4 py-3 border-t">{{ $servicios->links() }}</div>
    </div>
</div>
