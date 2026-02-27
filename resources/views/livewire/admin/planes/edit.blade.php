<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-edit mr-2"></i>
            Editar Plan Exequial
        </h2>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form wire:submit="update">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div class="md:col-span-2">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Plan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nombre"
                           wire:model="nombre" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('nombre') border-red-500 @enderror">
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                        Descripción
                    </label>
                    <textarea id="descripcion"
                              wire:model="descripcion" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('descripcion') border-red-500 @enderror"></textarea>
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo -->
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipo de Plan <span class="text-red-500">*</span>
                    </label>
                    <select id="tipo"
                            wire:model.live="tipo" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('tipo') border-red-500 @enderror">
                        <option value="individual">Individual</option>
                        <option value="familiar">Familiar</option>
                        <option value="empresarial">Empresarial</option>
                        <option value="anticipado">Anticipado</option>
                    </select>
                    @error('tipo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Máximo Beneficiarios -->
                <div>
                    <label for="max_beneficiarios" class="block text-sm font-medium text-gray-700 mb-2">
                        Máximo de Beneficiarios <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="max_beneficiarios"
                           wire:model="max_beneficiarios" 
                           min="1" 
                           max="100"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('max_beneficiarios') border-red-500 @enderror">
                    @error('max_beneficiarios')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio Mensual -->
                <div>
                    <label for="precio_mensual" class="block text-sm font-medium text-gray-700 mb-2">
                        Precio Mensual (COP) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                        <input type="number" 
                               id="precio_mensual"
                               wire:model="precio_mensual" 
                               min="0" 
                               step="1000"
                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('precio_mensual') border-red-500 @enderror">
                    </div>
                    @error('precio_mensual')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio Anual -->
                <div>
                    <label for="precio_anual" class="block text-sm font-medium text-gray-700 mb-2">
                        Precio Anual (COP) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                        <input type="number" 
                               id="precio_anual"
                               wire:model="precio_anual" 
                               min="0" 
                               step="1000"
                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('precio_anual') border-red-500 @enderror">
                    </div>
                    @error('precio_anual')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Servicios Incluidos -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Servicios Incluidos
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                        @foreach($serviciosDisponibles as $key => $label)
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors
                                {{ in_array($key, $servicios_incluidos) ? 'bg-blue-50 border-blue-500' : '' }}">
                                <input type="checkbox" 
                                       wire:click="toggleServicio('{{ $key }}')"
                                       {{ in_array($key, $servicios_incluidos) ? 'checked' : '' }}
                                       class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Estado -->
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               wire:model="activo"
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Plan activo (disponible para nuevos afiliados)</span>
                    </label>
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.planes.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        wire:loading.attr="disabled"
                        wire:target="update" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Actualizar Plan
                </button>
            </div>
        </form>
    </div>
</div>

