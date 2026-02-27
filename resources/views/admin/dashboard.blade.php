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
            <!-- Total Usuarios -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Usuarios</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">0</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-users text-blue-500 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Afiliados Activos -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Afiliados Activos</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">0</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-user-check text-green-500 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Ingresos Mensuales -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Ingresos Mensuales</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">$0</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-dollar-sign text-yellow-500 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Servicios Pendientes -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Servicios Pendientes</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">0</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <i class="fas fa-clock text-red-500 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos y Tablas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Actividad Reciente -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-history mr-2"></i>
                    Actividad Reciente
                </h3>
                <div class="space-y-4">
                    <p class="text-gray-500 text-center py-8">
                        No hay actividad reciente para mostrar
                    </p>
                </div>
            </div>

            <!-- Estadísticas por Plan -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chart-pie mr-2"></i>
                    Estadísticas por Plan
                </h3>
                <div class="space-y-4">
                    <p class="text-gray-500 text-center py-8">
                        No hay datos disponibles
                    </p>
                </div>
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-bolt mr-2"></i>
                Accesos Rápidos
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <a href="#" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-user-plus text-2xl text-blue-500 mb-2"></i>
                    <span class="text-sm text-gray-700">Nuevo Usuario</span>
                </a>
                <a href="#" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-user-friends text-2xl text-green-500 mb-2"></i>
                    <span class="text-sm text-gray-700">Nuevo Afiliado</span>
                </a>
                <a href="#" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-hand-holding-heart text-2xl text-red-500 mb-2"></i>
                    <span class="text-sm text-gray-700">Nuevo Servicio</span>
                </a>
                <a href="#" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-file-contract text-2xl text-purple-500 mb-2"></i>
                    <span class="text-sm text-gray-700">Nuevo Plan</span>
                </a>
                <a href="#" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-money-bill-wave text-2xl text-yellow-500 mb-2"></i>
                    <span class="text-sm text-gray-700">Registrar Pago</span>
                </a>
                <a href="#" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-chart-bar text-2xl text-indigo-500 mb-2"></i>
                    <span class="text-sm text-gray-700">Ver Reportes</span>
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>

