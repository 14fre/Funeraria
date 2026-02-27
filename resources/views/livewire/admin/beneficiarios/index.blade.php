<div>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-user-tag mr-2"></i>
            Beneficiarios
        </h2>
        <a href="{{ route('admin.beneficiarios.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-plus mr-2"></i>Nuevo Beneficiario
        </a>
    </div>
    @if (session()->has('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
    @endif
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Nombres, apellidos o documento..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Afiliado</label>
                <select wire:model.live="afiliadoFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    @foreach($afiliadosPaginator as $af)
                        <option value="{{ $af->id }}">{{ $af->numero_afiliacion }} - {{ $af->user->name ?? '' }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Por página</label>
                <select wire:model.live="perPage" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Documento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre completo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Afiliado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parentesco</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($beneficiarios as $b)
                    <tr class="hover:bg-gray-50" wire:key="beneficiario-{{ $b->id }}">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $b->tipo_documento }} {{ $b->numero_documento }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $b->nombres }} {{ $b->apellidos }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $b->afiliado->numero_afiliacion ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $b->parentesco }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $b->activo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $b->activo ? 'Activo' : 'Inactivo' }}</span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('admin.beneficiarios.edit', $b) }}" class="text-yellow-600 hover:text-yellow-900 mr-3"><i class="fas fa-edit"></i></a>
                            <button wire:click="delete({{ $b->id }})" wire:confirm="¿Eliminar este beneficiario?" wire:loading.attr="disabled" wire:target="delete" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay beneficiarios.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="bg-gray-50 px-4 py-3 border-t">{{ $beneficiarios->links() }}</div>
    </div>
</div>
