<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-cog mr-2"></i>
            Configuración general
        </h2>
    </x-slot>
    @section('page-title', 'Configuración general')

    <div class="py-6 max-w-4xl">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <p class="text-gray-700">
                Aquí puedes actualizar los <strong>datos generales de la funeraria</strong> que se muestran en la
                página pública (dirección, ciudad, teléfonos, email y WhatsApp).
            </p>
            <p class="text-sm text-gray-500 mt-2">
                Los cambios se reflejarán en la sección de <em>Contacto</em> y en el <em>footer</em> del sitio.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('admin.configuracion.update') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="empresa_nombre" class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre de la funeraria <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="empresa_nombre" name="empresa_nombre"
                           value="{{ old('empresa_nombre', $settings['empresa_nombre']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('empresa_nombre') border-red-500 @enderror">
                    @error('empresa_nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="empresa_direccion" class="block text-sm font-medium text-gray-700 mb-1">
                            Dirección principal <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="empresa_direccion" name="empresa_direccion"
                               value="{{ old('empresa_direccion', $settings['empresa_direccion']) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('empresa_direccion') border-red-500 @enderror">
                        @error('empresa_direccion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="empresa_ciudad" class="block text-sm font-medium text-gray-700 mb-1">
                            Ciudad / Departamento <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="empresa_ciudad" name="empresa_ciudad"
                               value="{{ old('empresa_ciudad', $settings['empresa_ciudad']) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('empresa_ciudad') border-red-500 @enderror">
                        @error('empresa_ciudad')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="empresa_telefonos" class="block text-sm font-medium text-gray-700 mb-1">
                        Teléfonos (separados por guiones) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="empresa_telefonos" name="empresa_telefonos"
                           value="{{ old('empresa_telefonos', $settings['empresa_telefonos']) }}"
                           placeholder="Ej: 3186298729 - 3186298688 - 3176413998"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('empresa_telefonos') border-red-500 @enderror">
                    @error('empresa_telefonos')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="empresa_email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email de contacto <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="empresa_email" name="empresa_email"
                               value="{{ old('empresa_email', $settings['empresa_email']) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('empresa_email') border-red-500 @enderror">
                        @error('empresa_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="empresa_whatsapp" class="block text-sm font-medium text-gray-700 mb-1">
                            WhatsApp (formato internacional)
                        </label>
                        <input type="text" id="empresa_whatsapp" name="empresa_whatsapp"
                               value="{{ old('empresa_whatsapp', $settings['empresa_whatsapp']) }}"
                               placeholder="Ej: 573186298729"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('empresa_whatsapp') border-red-500 @enderror">
                        @error('empresa_whatsapp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="empresa_horario" class="block text-sm font-medium text-gray-700 mb-1">
                        Horario de atención (texto que se muestra en contacto)
                    </label>
                    <input type="text" id="empresa_horario" name="empresa_horario"
                           value="{{ old('empresa_horario', $settings['empresa_horario']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('empresa_horario') border-red-500 @enderror">
                    @error('empresa_horario')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
