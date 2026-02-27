<x-cliente-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-file-signature mr-2"></i>
            Solicitar afiliación a un plan
        </h2>
    </x-slot>
    @section('page-title', 'Solicitar afiliación')

    <div class="py-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl">
            <p class="text-gray-600 mb-4">Selecciona el plan al que deseas afiliarte. Un administrador revisará tu solicitud y te afiliará si todo está en orden. No podrás solicitar otro plan si ya tienes una solicitud pendiente.</p>
            <form action="{{ route('cliente.solicitar-afiliacion.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Plan exequial *</label>
                        <select name="plan_exequial_id" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="">Selecciona un plan</option>
                            @foreach ($planes as $plan)
                                <option value="{{ $plan->id }}" {{ old('plan_exequial_id') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->nombre }} — ${{ number_format($plan->precio_mensual, 0, ',', '.') }}/mes
                                </option>
                            @endforeach
                        </select>
                        @error('plan_exequial_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje (opcional)</label>
                        <textarea name="mensaje" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Comentarios o motivo de la solicitud...">{{ old('mensaje') }}</textarea>
                        @error('mensaje')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">Enviar solicitud</button>
                    <a href="{{ route('cliente.plan.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-cliente-layout>
