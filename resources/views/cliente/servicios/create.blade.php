<x-cliente-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-plus mr-2"></i>
            Solicitar Servicio Funerario
        </h2>
    </x-slot>
    @section('page-title', 'Solicitar Servicio')

    <div class="py-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl">
            <form action="{{ route('cliente.servicios.store') }}" method="POST">
                @csrf
                <input type="hidden" name="afiliado_id" value="{{ $afiliado->id }}">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de servicio *</label>
                        <select name="tipo" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="velacion">Velación</option>
                            <option value="velacion_virtual">Velación Virtual</option>
                            <option value="cremacion">Cremación</option>
                            <option value="traslado_nacional">Traslado Nacional</option>
                            <option value="traslado_internacional">Traslado Internacional</option>
                        </select>
                        @error('tipo')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Beneficiario (opcional)</label>
                        <select name="beneficiario_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="">— Seleccionar —</option>
                            @foreach ($afiliado->beneficiarios as $b)
                                <option value="{{ $b->id }}">{{ $b->nombre_completo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                        <textarea name="observaciones" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Indica detalles adicionales...">{{ old('observaciones') }}</textarea>
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">Enviar solicitud</button>
                    <a href="{{ route('cliente.servicios.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-cliente-layout>
