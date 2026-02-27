<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-user-edit mr-2"></i>
            Editar Afiliado
        </h2>
        <p class="text-gray-600 mt-1">Nº {{ $afiliado->numero_afiliacion }} — {{ $afiliado->user->name ?? '—' }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form wire:submit="update">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="plan_exequial_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Plan exequial <span class="text-red-500">*</span>
                    </label>
                    <select id="plan_exequial_id"
                            wire:model="plan_exequial_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('plan_exequial_id') border-red-500 @enderror">
                        @foreach($planes as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->nombre }}</option>
                        @endforeach
                    </select>
                    @error('plan_exequial_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha_afiliacion" class="block text-sm font-medium text-gray-700 mb-2">
                        Fecha de afiliación <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           id="fecha_afiliacion"
                           wire:model="fecha_afiliacion"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('fecha_afiliacion') border-red-500 @enderror">
                    @error('fecha_afiliacion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <select id="estado"
                            wire:model="estado"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('estado') border-red-500 @enderror">
                        @foreach($estados as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('estado')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="asesor_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Asesor
                    </label>
                    <select id="asesor_id"
                            wire:model="asesor_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Sin asesor</option>
                        @foreach($asesores as $a)
                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">
                        Observaciones
                    </label>
                    <textarea id="observaciones"
                              wire:model="observaciones"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Notas internas..."></textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors"
                        wire:loading.attr="disabled"
                        wire:target="update">
                    <i class="fas fa-save mr-2"></i>
                    Actualizar
                </button>
                <a href="{{ route('admin.afiliados.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
