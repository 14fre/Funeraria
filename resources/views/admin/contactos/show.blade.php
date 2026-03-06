<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-envelope-open-text mr-2"></i>
            Mensaje de contacto
        </h2>
    </x-slot>
    @section('page-title', 'Ver mensaje')

    <div class="py-6">
        <div class="mb-4">
            <a href="{{ route('admin.contactos.index') }}" class="text-[#5C0E2B] hover:underline">
                <i class="fas fa-arrow-left mr-1"></i> Volver al listado
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-3xl">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <p class="text-sm text-gray-500">Recibido el {{ $contacto->created_at->format('d/m/Y \a \l\a\s H:i') }}</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase">Nombre</label>
                    <p class="text-gray-900 font-medium">{{ $contacto->nombre }}</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase">Email</label>
                    <p>
                        <a href="mailto:{{ $contacto->email }}" class="text-[#5C0E2B] hover:underline">{{ $contacto->email }}</a>
                    </p>
                </div>
                @if($contacto->telefono)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase">Teléfono</label>
                        <p>
                            <a href="tel:{{ $contacto->telefono }}" class="text-[#5C0E2B] hover:underline">{{ $contacto->telefono }}</a>
                        </p>
                    </div>
                @endif
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase">Asunto</label>
                    <p class="text-gray-900 font-medium">{{ $contacto->asunto }}</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase">Mensaje</label>
                    <div class="mt-1 p-4 bg-gray-50 rounded-lg border border-gray-200 whitespace-pre-wrap text-gray-800">{{ $contacto->mensaje }}</div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex gap-3">
                <a href="mailto:{{ $contacto->email }}?subject=Re: {{ rawurlencode($contacto->asunto) }}"
                   class="inline-flex items-center px-4 py-2 bg-[#5C0E2B] text-white rounded-lg hover:bg-[#7a1a3d]">
                    <i class="fas fa-reply mr-2"></i>
                    Responder por correo
                </a>
                <a href="{{ route('admin.contactos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Volver al listado
                </a>
            </div>
        </div>

        @if(!$contacto->leido)
            <p class="mt-2 text-sm text-gray-500"><i class="fas fa-check text-green-500 mr-1"></i> Este mensaje se marcó como leído al abrirlo.</p>
        @endif
    </div>
</x-admin-layout>
