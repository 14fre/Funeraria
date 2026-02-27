<div>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-file-contract mr-2"></i>
            Detalles del Plan: {{ $plan->nombre }}
        </h2>
        <div class="flex space-x-3">
            <a href="{{ route('admin.planes.edit', $plan) }}" 
               class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-edit mr-2"></i>
                Editar
            </a>
            <a href="{{ route('admin.planes.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver
            </a>
        </div>
    </div>

    <!-- Estadísticas del Plan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Afiliados</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_afiliados'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users text-blue-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Afiliados Activos</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['afiliados_activos'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-user-check text-green-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Ingresos Mensuales</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">${{ number_format($stats['ingresos_mensuales'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-dollar-sign text-yellow-500 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del Plan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Información General -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-info-circle mr-2"></i>
                Información General
            </h3>
            <dl class="space-y-3">
                <div class="flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Nombre:</dt>
                    <dd class="text-sm text-gray-900">{{ $plan->nombre }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Tipo:</dt>
                    <dd class="text-sm text-gray-900">
                        <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                            {{ ucfirst($plan->tipo) }}
                        </span>
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Máximo Beneficiarios:</dt>
                    <dd class="text-sm text-gray-900">{{ $plan->max_beneficiarios }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Precio Mensual:</dt>
                    <dd class="text-sm text-gray-900 font-semibold">${{ number_format($plan->precio_mensual, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Precio Anual:</dt>
                    <dd class="text-sm text-gray-900 font-semibold">${{ number_format($plan->precio_anual, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Estado:</dt>
                    <dd class="text-sm text-gray-900">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $plan->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $plan->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </dd>
                </div>
                @if($plan->descripcion)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">Descripción:</dt>
                        <dd class="text-sm text-gray-900">{{ $plan->descripcion }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <!-- Servicios Incluidos -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-list-check mr-2"></i>
                Servicios Incluidos
            </h3>
            @if($plan->servicios_incluidos && count($plan->servicios_incluidos) > 0)
                <div class="grid grid-cols-2 gap-2">
                    @foreach($plan->servicios_incluidos as $servicio)
                        <div class="flex items-center p-2 bg-blue-50 rounded-lg">
                            <i class="fas fa-check-circle text-blue-500 mr-2"></i>
                            <span class="text-sm text-gray-700">{{ $serviciosLabels[$servicio] ?? $servicio }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">No hay servicios incluidos definidos.</p>
            @endif
        </div>
    </div>

    <!-- Afiliados del Plan -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-users mr-2"></i>
            Afiliados con este Plan
        </h3>
        @if($plan->afiliados->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Número Afiliación</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Afiliación</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($plan->afiliados->take(10) as $afiliado)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $afiliado->numero_afiliacion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $afiliado->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $afiliado->fecha_afiliacion->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $afiliado->estado === 'activo' ? 'bg-green-100 text-green-800' : 
                                           ($afiliado->estado === 'mora' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($afiliado->estado) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($plan->afiliados->count() > 10)
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-500">Mostrando 10 de {{ $plan->afiliados->count() }} afiliados</p>
                </div>
            @endif
        @else
            <p class="text-sm text-gray-500">No hay afiliados con este plan.</p>
        @endif
    </div>
</div>

