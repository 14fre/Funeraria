<x-cliente-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-user-plus mr-2"></i>
            Agregar Beneficiario
        </h2>
    </x-slot>
    @section('page-title', 'Nuevo Beneficiario')

    <div class="py-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl">
            <p class="text-gray-600 mb-4">Plan: <strong>{{ $afiliado->planExequial->nombre }}</strong>. Puedes agregar hasta <strong>{{ $afiliado->planExequial->max_beneficiarios }}</strong> beneficiarios.</p>
            <form action="{{ route('cliente.beneficiarios.store') }}" method="POST">
                @csrf
                <input type="hidden" name="afiliado_id" value="{{ $afiliado->id }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo documento *</label>
                        <select name="tipo_documento" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="CC">Cédula</option>
                            <option value="CE">Cédula extranjería</option>
                            <option value="TI">Tarjeta identidad</option>
                            <option value="PASAPORTE">Pasaporte</option>
                        </select>
                        @error('tipo_documento')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número documento *</label>
                        <input type="text" name="numero_documento" value="{{ old('numero_documento') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        @error('numero_documento')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombres *</label>
                        <input type="text" name="nombres" value="{{ old('nombres') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        @error('nombres')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos *</label>
                        <input type="text" name="apellidos" value="{{ old('apellidos') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        @error('apellidos')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha nacimiento *</label>
                        <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        @error('fecha_nacimiento')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Parentesco *</label>
                        <input type="text" name="parentesco" value="{{ old('parentesco') }}" placeholder="Ej: Cónyuge, Hijo" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        @error('parentesco')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                @if ($errors->has('afiliado_id'))
                    <p class="text-red-600 text-sm mt-2">{{ $errors->first('afiliado_id') }}</p>
                @endif
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">Guardar</button>
                    <a href="{{ route('cliente.beneficiarios.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-cliente-layout>
