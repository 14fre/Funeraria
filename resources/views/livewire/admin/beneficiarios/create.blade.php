<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800"><i class="fas fa-user-plus mr-2"></i>Nuevo Beneficiario</h2>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Afiliado <span class="text-red-500">*</span></label>
                    <select wire:model="afiliado_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg @error('afiliado_id') border-red-500 @enderror">
                        <option value="">Seleccione afiliado</option>
                        @foreach($afiliadosList as $af)
                            <option value="{{ $af->id }}">{{ $af->numero_afiliacion }} - {{ $af->user->name ?? '' }}</option>
                        @endforeach
                    </select>
                    @error('afiliado_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo doc. <span class="text-red-500">*</span></label>
                    <select wire:model="tipo_documento" class="w-full px-3 py-2 border border-gray-300 rounded-lg">@foreach(['CC'=>'Cédula','CE'=>'Cédula extranjería','TI'=>'Tarjeta identidad','PASAPORTE'=>'Pasaporte'] as $v=>$l)<option value="{{ $v }}">{{ $l }}</option>@endforeach</select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Número documento <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="numero_documento" class="w-full px-3 py-2 border border-gray-300 rounded-lg @error('numero_documento') border-red-500 @enderror">@error('numero_documento')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombres <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="nombres" class="w-full px-3 py-2 border border-gray-300 rounded-lg @error('nombres') border-red-500 @enderror">@error('nombres')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Apellidos <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="apellidos" class="w-full px-3 py-2 border border-gray-300 rounded-lg @error('apellidos') border-red-500 @enderror">@error('apellidos')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha nacimiento <span class="text-red-500">*</span></label>
                    <input type="date" wire:model="fecha_nacimiento" class="w-full px-3 py-2 border border-gray-300 rounded-lg @error('fecha_nacimiento') border-red-500 @enderror">@error('fecha_nacimiento')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Género</label>
                    <select wire:model="genero" class="w-full px-3 py-2 border border-gray-300 rounded-lg"><option value="">—</option><option value="M">Masculino</option><option value="F">Femenino</option><option value="Otro">Otro</option></select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Parentesco <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="parentesco" placeholder="Ej: Cónyuge, Hijo" class="w-full px-3 py-2 border border-gray-300 rounded-lg @error('parentesco') border-red-500 @enderror">@error('parentesco')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                    <input type="text" wire:model="telefono" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" wire:model="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg @error('email') border-red-500 @enderror">@error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                    <input type="text" wire:model="direccion" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad</label>
                    <input type="text" wire:model="ciudad" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Departamento</label>
                    <input type="text" wire:model="departamento" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div class="md:col-span-2">
                    <label class="inline-flex items-center"><input type="checkbox" wire:model="activo" class="rounded border-gray-300"> <span class="ml-2">Activo</span></label>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg" wire:loading.attr="disabled" wire:target="save">Guardar</button>
                <a href="{{ route('admin.beneficiarios.index') }}" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">Cancelar</a>
            </div>
        </form>
    </div>
</div>
