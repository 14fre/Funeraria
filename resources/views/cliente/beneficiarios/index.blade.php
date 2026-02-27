<x-cliente-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-user-friends mr-2"></i>
            Mis Beneficiarios
        </h2>
    </x-slot>
    @section('page-title', 'Beneficiarios')

    <div class="py-6">
        @if (!$afiliado)
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-600">No tienes un plan asignado. Contacta con la funeraria para afiliarte y poder gestionar beneficiarios.</p>
                <a href="{{ route('cliente.dashboard') }}" class="inline-block mt-4 text-red-600 hover:text-red-700 font-medium">Volver al dashboard</a>
            </div>
        @else
            <div class="mb-4 flex justify-end">
                <a href="{{ route('cliente.beneficiarios.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i>Agregar beneficiario
                </a>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if ($beneficiarios->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Documento</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre completo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parentesco</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($beneficiarios as $b)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $b->tipo_documento }} {{ $b->numero_documento }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $b->nombres }} {{ $b->apellidos }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $b->parentesco }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $b->activo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $b->activo ? 'Activo' : 'Inactivo' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-8 text-center text-gray-500">
                        <i class="fas fa-user-friends text-4xl mb-3"></i>
                        <p>No tienes beneficiarios registrados.</p>
                        <a href="{{ route('cliente.beneficiarios.create') }}" class="inline-block mt-3 text-red-600 hover:text-red-700 font-medium">Agregar el primero</a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-cliente-layout>
