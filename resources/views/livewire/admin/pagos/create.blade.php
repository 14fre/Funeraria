<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-money-bill-wave mr-2"></i>
            Registrar pago
        </h2>
        <p class="text-gray-600 mt-1">Alta manual de pago. El plan se completa automáticamente al elegir el afiliado.</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="afiliado_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Afiliado <span class="text-red-500">*</span>
                    </label>
                    <select id="afiliado_id"
                            wire:model.live="afiliado_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('afiliado_id') border-red-500 @enderror">
                        <option value="">Seleccione un afiliado</option>
                        @foreach($afiliados as $a)
                            <option value="{{ $a->id }}">Nº {{ $a->numero_afiliacion }} — {{ $a->user->name ?? '—' }}</option>
                        @endforeach
                    </select>
                    @error('afiliado_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="plan_exequial_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Plan exequial <span class="text-red-500">*</span>
                    </label>
                    <select id="plan_exequial_id"
                            wire:model="plan_exequial_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('plan_exequial_id') border-red-500 @enderror">
                        <option value="">Seleccione un plan</option>
                        @foreach($planes as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->nombre }}</option>
                        @endforeach
                    </select>
                    @error('plan_exequial_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="monto" class="block text-sm font-medium text-gray-700 mb-2">
                        Monto <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           id="monto"
                           wire:model="monto"
                           step="0.01"
                           min="1"
                           placeholder="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('monto') border-red-500 @enderror">
                    @error('monto')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="metodo_pago" class="block text-sm font-medium text-gray-700 mb-2">
                        Método de pago <span class="text-red-500">*</span>
                    </label>
                    <select id="metodo_pago"
                            wire:model="metodo_pago"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        @foreach($metodos as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <select id="estado"
                            wire:model="estado"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        @foreach($estados as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="fecha_pago" class="block text-sm font-medium text-gray-700 mb-2">
                        Fecha de pago <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           id="fecha_pago"
                           wire:model="fecha_pago"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('fecha_pago') border-red-500 @enderror">
                    @error('fecha_pago')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="referencia" class="block text-sm font-medium text-gray-700 mb-2">Referencia</label>
                    <input type="text"
                           id="referencia"
                           wire:model="referencia"
                           placeholder="Ej. Transferencia, cheque..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="numero_recibo" class="block text-sm font-medium text-gray-700 mb-2">Nº Recibo</label>
                    <input type="text"
                           id="numero_recibo"
                           wire:model="numero_recibo"
                           placeholder="Opcional"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">Observaciones</label>
                    <textarea id="observaciones"
                              wire:model="observaciones"
                              rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Notas internas..."></textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors"
                        wire:loading.attr="disabled"
                        wire:target="save">
                    <i class="fas fa-save mr-2"></i>
                    Guardar pago
                </button>
                <a href="{{ route('admin.pagos.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
