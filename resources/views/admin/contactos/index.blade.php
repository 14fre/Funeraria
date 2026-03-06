<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-envelope mr-2"></i>
            Mensajes de contacto
        </h2>
    </x-slot>
    @section('page-title', 'Mensajes de contacto')

    <div class="py-6">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-gray-700">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                Aquí aparecen los mensajes que envían las personas desde el <strong>formulario de contacto</strong> del sitio web.
                Puedes ver el detalle, responderles por correo o teléfono y marcar como leído cuando los hayas atendido.
            </p>
            @if($noLeidos > 0)
                <p class="mt-2 font-semibold text-[#5C0E2B]">
                    <i class="fas fa-bell mr-1"></i> Tienes <strong>{{ $noLeidos }}</strong> mensaje(s) sin leer.
                </p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email / Teléfono</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asunto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($contactos as $c)
                            <tr class="hover:bg-gray-50 {{ !$c->leido ? 'bg-amber-50/50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($c->leido)
                                        <span class="text-gray-400 text-sm"><i class="fas fa-check-circle mr-1"></i>Leído</span>
                                    @else
                                        <span class="text-amber-700 font-medium text-sm"><i class="fas fa-circle mr-1"></i>Sin leer</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-900">{{ $c->nombre }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="mailto:{{ $c->email }}" class="text-blue-600 hover:underline">{{ $c->email }}</a>
                                    @if($c->telefono)
                                        <br><a href="tel:{{ $c->telefono }}" class="text-gray-600">{{ $c->telefono }}</a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($c->asunto, 40) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $c->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('admin.contactos.show', $c) }}"
                                       class="text-[#5C0E2B] hover:text-[#7a1a3d] font-medium">
                                        <i class="fas fa-eye mr-1"></i>Ver mensaje
                                    </a>
                                    @if(!$c->leido)
                                        <span class="text-gray-300 mx-1">|</span>
                                        <a href="{{ route('admin.contactos.marcar-leido', $c) }}"
                                           class="text-gray-600 hover:text-gray-900">
                                            Marcar leído
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2 block text-gray-300"></i>
                                    Aún no hay mensajes de contacto. Los que envíen desde el formulario del sitio aparecerán aquí.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($contactos->hasPages())
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                    {{ $contactos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
