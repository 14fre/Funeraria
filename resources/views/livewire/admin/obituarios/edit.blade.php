<div class="bg-white rounded-lg shadow-md p-6 max-w-4xl">
    <form wire:submit="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo *</label>
                <input type="text" wire:model="nombre_completo" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                @error('nombre_completo')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Número de cédula</label>
                <input type="text" wire:model="numero_documento" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Servicio funerario (opcional)</label>
                <select wire:model="servicio_funerario_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Ninguno</option>
                    @foreach($servicios as $s)
                        <option value="{{ $s->id }}">#{{ $s->id }} - {{ $s->tipo }} ({{ $s->fecha_solicitud?->format('d/m/Y') }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha nacimiento</label>
                <input type="date" wire:model="fecha_nacimiento" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha fallecimiento *</label>
                <input type="date" wire:model="fecha_fallecimiento" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                @error('fecha_fallecimiento')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Lugar fallecimiento</label>
                <input type="text" wire:model="lugar_fallecimiento" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Biografía</label>
                <textarea wire:model="biografia" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje de la familia</label>
                <textarea wire:model="mensaje_familia" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto (cambiar)</label>
                <input type="file" wire:model="foto" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gray-100 file:text-gray-700">
                @if($obituario->foto)
                    <p class="text-xs text-gray-500 mt-1">Actual: {{ $obituario->foto }}</p>
                @endif
                @error('foto')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Publicado</label>
                <select wire:model="publicado" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>
            <div class="md:col-span-2 border-t pt-4 mt-2">
                <h3 class="font-semibold text-gray-800 mb-2">Velación</h3>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha velación</label>
                <input type="date" wire:model="fecha_velacion" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lugar velación</label>
                <input type="text" wire:model="lugar_velacion" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="md:col-span-2 border-t pt-4 mt-2">
                <h3 class="font-semibold text-gray-800 mb-2">Sepultura</h3>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha sepultura</label>
                <input type="date" wire:model="fecha_sepultura" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lugar sepultura</label>
                <input type="text" wire:model="lugar_sepultura" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg" wire:loading.attr="disabled" wire:target="save">
                <i class="fas fa-save mr-2"></i>Actualizar
            </button>
            <a href="{{ route('admin.obituarios.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">Cancelar</a>
        </div>
    </form>
</div>
