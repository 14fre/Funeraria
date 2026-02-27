<div>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-door-open mr-2"></i>
            Salas de velación
        </h2>
        <a href="{{ route('admin.salas.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Nueva sala
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
            <p class="text-gray-600 text-sm font-medium">Total</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500">
            <p class="text-gray-600 text-sm font-medium">Disponibles</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['disponible'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-red-500">
            <p class="text-gray-600 text-sm font-medium">Ocupadas</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['ocupada'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-yellow-500">
            <p class="text-gray-600 text-sm font-medium">Mantenimiento</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['mantenimiento'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <input type="text"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Nombre, ubicación..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select wire:model.live="estadoFilter"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    @foreach($estados as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Por página</label>
                <select wire:model.live="perPage"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th wire:click="sortBy('nombre')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            <div class="flex items-center">Nombre
                                @if($sortField === 'nombre')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-2"></i>
                                @else
                                    <i class="fas fa-sort ml-2 text-gray-300"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capacidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio/hora</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($salas as $sala)
                        <tr class="hover:bg-gray-50" wire:key="sala-{{ $sala->id }}">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $sala->nombre }}</div>
                                @if($sala->descripcion)
                                    <div class="text-xs text-gray-500">{{ Str::limit($sala->descripcion, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $sala->capacidad }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $sala->ubicacion ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($sala->precio_hora, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($sala->estado === 'disponible')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disponible</span>
                                @elseif($sala->estado === 'ocupada')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ocupada</span>
                                @elseif($sala->estado === 'mantenimiento')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Mantenimiento</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Fuera de servicio</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.salas.edit', $sala) }}"
                                   class="text-yellow-600 hover:text-yellow-900 mr-3" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button wire:click="delete({{ $sala->id }})"
                                        wire:confirm="¿Eliminar esta sala?"
                                        wire:loading.attr="disabled"
                                        wire:target="delete"
                                        class="text-red-600 hover:text-red-900" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay salas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
            {{ $salas->links() }}
        </div>
    </div>
</div>
