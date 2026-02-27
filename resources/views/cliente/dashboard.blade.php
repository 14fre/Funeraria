<x-cliente-layout>
    <x-slot name="pageTitle">Mi Dashboard</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-home mr-2"></i>
            Mi Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <!-- Bienvenida (vinotinto / dorado, digno del cliente) -->
        <div class="bg-gradient-to-r from-[#5C0E2B] to-[#3d0a1e] rounded-xl shadow-lg p-6 mb-6 text-white">
            <h1 class="text-2xl font-bold mb-2">
                <i class="fas fa-hand-holding-heart mr-2 text-[#FFD700]"></i>
                Bienvenido, {{ Auth::user()->name }}
            </h1>
            <p class="text-[#F0E68C]">Aquí puedes gestionar tu plan exequial y servicios con tranquilidad.</p>
        </div>

        <!-- Resumen del Plan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <!-- Información del Plan -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-[#FFD700]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Mi Plan</h3>
                    <i class="fas fa-file-contract text-[#5C0E2B] text-2xl"></i>
                </div>
                <p class="text-gray-600 text-sm mb-2">Estado:</p>
                <p class="text-xl font-bold text-gray-800">{{ $afiliado ?? null ? $afiliado->planExequial->nombre ?? 'Sin plan' : 'Sin Plan Asignado' }}</p>
                <a href="{{ route('cliente.plan.index') }}" class="text-[#5C0E2B] hover:text-[#7a1a3d] font-medium text-sm mt-4 inline-block">
                    {{ ($afiliado ?? null) ? 'Ver detalles' : 'Solicitar afiliación' }} <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <!-- Beneficiarios -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-[#142a41]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Beneficiarios</h3>
                    <i class="fas fa-user-friends text-[#142a41] text-2xl"></i>
                </div>
                <p class="text-gray-600 text-sm mb-2">Total:</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalBeneficiarios ?? 0 }}</p>
                <a href="{{ route('cliente.beneficiarios.index') }}" class="text-[#142a41] hover:text-[#1e3a5f] font-medium text-sm mt-4 inline-block">
                    Gestionar <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <!-- Próximo Pago -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-emerald-600">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Próximo Pago</h3>
                    <i class="fas fa-calendar-check text-emerald-600 text-2xl"></i>
                </div>
                <p class="text-gray-600 text-sm mb-2">Fecha:</p>
                <p class="text-xl font-bold text-gray-800">{{ $proximoPago ?? 'No programado' }}</p>
                <a href="{{ route('cliente.pagos.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium text-sm mt-4 inline-block">
                    Realizar pago <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Solicitar Servicio -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow border border-gray-100">
                <div class="flex items-center mb-4">
                    <div class="bg-[#5C0E2B]/10 p-3 rounded-full mr-4">
                        <i class="fas fa-hand-holding-heart text-[#5C0E2B] text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Solicitar Servicio</h3>
                        <p class="text-gray-600 text-sm">Solicita un servicio funerario con respeto y dignidad.</p>
                    </div>
                </div>
                <a href="{{ route('cliente.servicios.create') }}" class="block w-full bg-[#5C0E2B] text-white text-center py-2.5 rounded-xl hover:bg-[#7a1a3d] transition-colors font-medium">
                    Solicitar Ahora
                </a>
            </div>

            <!-- Realizar Pago -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow border border-gray-100">
                <div class="flex items-center mb-4">
                    <div class="bg-emerald-100 p-3 rounded-full mr-4">
                        <i class="fas fa-money-bill-wave text-emerald-600 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Realizar Pago</h3>
                        <p class="text-gray-600 text-sm">Paga tu plan exequial en línea de forma segura.</p>
                    </div>
                </div>
                <a href="{{ route('cliente.pagos.index') }}" class="block w-full bg-emerald-600 text-white text-center py-2.5 rounded-xl hover:bg-emerald-700 transition-colors font-medium">
                    Pagar Ahora
                </a>
            </div>
        </div>

        <!-- Historial Reciente -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-history mr-2 text-[#5C0E2B]"></i>
                    Historial Reciente
                </h3>
                <a href="{{ route('cliente.pagos.index') }}" class="text-sm text-[#5C0E2B] hover:text-[#7a1a3d] font-medium">
                    Ver todo <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-4">
                <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-xl">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 font-medium">No hay historial disponible</p>
                    <p class="text-gray-400 text-sm mt-1">Tu historial de actividades aparecerá aquí</p>
                </div>
            </div>
        </div>
    </div>
</x-cliente-layout>

