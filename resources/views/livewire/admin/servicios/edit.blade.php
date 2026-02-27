<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800"><i class="fas fa-edit mr-2"></i>Editar Servicio</h2>
        <p class="text-gray-600">Afiliado: {{ $servicio->afiliado->numero_afiliacion ?? '' }} — {{ $servicio->afiliado->user->name ?? '' }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <form wire:submit="update">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Beneficiario</label>
                    <select wire:model="beneficiario_id" class="w-full px-3 py-2 border rounded-lg">
                        <option value="">—</option>
                        @foreach($beneficiarios as $b)<option value="{{ $b->id }}">{{ $b->nombre_completo }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo <span class="text-red-500">*</span></label>
                    <select wire:model="tipo" class="w-full px-3 py-2 border rounded-lg">@foreach($tipos as $k=>$v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado <span class="text-red-500">*</span></label>
                    <select wire:model="estado" class="w-full px-3 py-2 border rounded-lg">@foreach($estados as $k=>$v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha solicitud <span class="text-red-500">*</span></label>
                    <input type="date" wire:model="fecha_solicitud" class="w-full px-3 py-2 border rounded-lg">@error('fecha_solicitud')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha servicio</label>
                    <input type="date" wire:model="fecha_servicio" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hora servicio</label>
                    <input type="time" wire:model="hora_servicio" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Coordinador</label>
                    <select wire:model="coordinador_id" class="w-full px-3 py-2 border rounded-lg">
                        <option value="">—</option>
                        @foreach($coordinadores as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Costo adicional (COP)</label>
                    <input type="number" step="0.01" wire:model="costo_adicional" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones</label>
                    <textarea wire:model="observaciones" rows="2" class="w-full px-3 py-2 border rounded-lg"></textarea>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg" wire:loading.attr="disabled" wire:target="update">Actualizar</button>
                <a href="{{ route('admin.servicios.index') }}" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">Cancelar</a>
            </div>
        </form>
    </div>
</div>
