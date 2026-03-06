<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-home mr-2"></i>
            Dashboard Administrativo
        </h2>
    </x-slot>

    @section('page-title', 'Dashboard Administrativo')

    <div class="py-6">
        <!-- Estadísticas Principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Usuarios</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalUsuarios ?? 0) }}</p>
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
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($afiliadosActivos ?? 0) }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-user-check text-green-500 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Ingresos del mes</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">${{ number_format($ingresosMensuales ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-dollar-sign text-yellow-500 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Servicios pendientes</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($serviciosPendientes ?? 0) }}</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <i class="fas fa-clock text-red-500 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-history mr-2"></i>
                    Actividad reciente
                </h3>
                <div class="space-y-3">
                    @forelse($actividadReciente ?? [] as $item)
                        <div class="flex justify-between items-start text-sm py-2 border-b border-gray-100 last:border-0">
                            <span class="text-gray-700">{{ $item['texto'] }}</span>
                            <span class="text-gray-500 whitespace-nowrap ml-2">{{ $item['fecha'] }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No hay actividad reciente.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chart-pie mr-2"></i>
                    Afiliados por plan
                </h3>
                <div class="space-y-3">
                    @forelse($porPlan ?? [] as $plan)
                        <div class="flex justify-between items-center text-sm py-2 border-b border-gray-100 last:border-0">
                            <span class="text-gray-700">{{ $plan->nombre }}</span>
                            <span class="font-medium text-gray-800">{{ $plan->afiliados_count }} activos</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No hay datos por plan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Accesos rápidos -->
        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-bolt mr-2"></i>
                Accesos rápidos
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <a href="{{ route('admin.usuarios.create') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-user-plus text-2xl text-blue-500 mb-2"></i>
                    <span class="text-sm text-gray-700">Nuevo usuario</span>
                </a>
                <a href="{{ route('admin.afiliados.create') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-user-friends text-2xl text-green-500 mb-2"></i>
                    <span class="text-sm text-gray-700">Nuevo afiliado</span>
                </a>
                <a href="{{ route('admin.servicios.index') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-hand-holding-heart text-2xl text-red-500 mb-2"></i>
                    <span class="text-sm text-gray-700">Servicios</span>
                </a>
                <a href="{{ route('admin.planes.index') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-file-contract text-2xl text-purple-500 mb-2"></i>
                    <span class="text-sm text-gray-700">Planes</span>
                </a>
                <a href="{{ route('admin.pagos.index') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-money-bill-wave text-2xl text-yellow-500 mb-2"></i>
                    <span class="text-sm text-gray-700">Pagos</span>
                </a>
                <a href="{{ route('admin.reportes.index') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-chart-bar text-2xl text-indigo-500 mb-2"></i>
                    <span class="text-sm text-gray-700">Reportes</span>
                </a>
            </div>
        </div>
    </div>

</x-admin-layout>
