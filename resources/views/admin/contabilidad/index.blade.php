<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-chart-line mr-2"></i>
            Finanzas
        </h2>
    </x-slot>

    @section('page-title', 'Finanzas')

    <div class="py-6 space-y-8">
        {{-- Selector mes / año (desde el primer registro hasta hoy) --}}
        <div class="bg-white rounded-lg shadow-md p-4">
            <p class="text-sm text-gray-600 mb-2">Elija el mes y año para ver el resumen y descargar el reporte (desde el primer registro en el sistema).</p>
            <form method="get" action="{{ route('admin.contabilidad.index') }}" class="flex flex-wrap items-center gap-4">
                <label class="text-sm font-medium text-gray-700">Período:</label>
                <select name="mes" class="rounded-lg border-gray-300 text-sm">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ (int) $mes === $m ? 'selected' : '' }}>{{ \Carbon\Carbon::createFromDate($anio, $m, 1)->translatedFormat('F') }}</option>
                    @endforeach
                </select>
                <select name="anio" class="rounded-lg border-gray-300 text-sm">
                    @foreach($aniosDisponibles ?? range(now()->year, now()->year - 5) as $a)
                        <option value="{{ $a }}" {{ (int) $anio === $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-3 py-1.5 bg-[#5C0E2B] text-white rounded-lg text-sm hover:bg-[#7a1a3d]">Ver</button>
            </form>
        </div>

        {{-- Resumen del mes --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-coins mr-2"></i>
                Resumen {{ $nombreMes }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                    <p class="text-sm text-gray-600">Entradas (pagos aprobados)</p>
                    <p class="text-2xl font-bold text-green-700">${{ number_format($entradas ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $cantidadPagos ?? 0 }} pagos</p>
                </div>
                <div class="bg-amber-50 rounded-lg p-4 border border-amber-100">
                    <p class="text-sm text-gray-600">Salidas / Egresos</p>
                    <p class="text-2xl font-bold text-amber-700">En implementación</p>
                    <p class="text-xs text-gray-500 mt-1">Registro de gastos operativos</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-600">Balance del mes</p>
                    <p class="text-2xl font-bold text-gray-800">${{ number_format($entradas ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">Solo entradas por ahora</p>
                </div>
            </div>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <span class="text-sm font-medium text-gray-700">Descargar reporte:</span>
                <a href="{{ route('admin.contabilidad.reporte-mensual', ['mes' => $mes, 'anio' => $anio, 'imprimir' => 1]) }}"
                   target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-[#5C0E2B] text-white rounded-lg hover:bg-[#7a1a3d] text-sm">
                    <i class="fas fa-file-pdf mr-2"></i>
                    Mensual ({{ $nombreMes }})
                </a>
                <span class="text-gray-400">|</span>
                <span class="text-sm text-gray-600">Anual:</span>
                <select id="anio-reporte-anual" class="rounded-lg border-gray-300 text-sm py-1.5">
                    @foreach($aniosDisponibles ?? [] as $a)
                        <option value="{{ $a }}" {{ (int) $anio === $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
                <a href="{{ route('admin.contabilidad.reporte-anual', ['anio' => $anio, 'imprimir' => 1]) }}" id="btn-reporte-anual" target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 text-sm">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Ver / PDF
                </a>
            </div>
            <script>
                (function() {
                    var sel = document.getElementById('anio-reporte-anual');
                    var btn = document.getElementById('btn-reporte-anual');
                    if (!sel || !btn) return;
                    var urlBase = '{{ route("admin.contabilidad.reporte-anual", ["anio" => 0]) }}';
                    function updateHref() {
                        btn.href = urlBase.replace('anio=0', 'anio=' + sel.value + '&imprimir=1');
                    }
                    sel.addEventListener('change', updateHref);
                    updateHref();
                })();
            </script>
        </div>

        {{-- Dos gráficos en fila --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chart-area mr-2"></i>
                    Tendencia de entradas (12 meses)
                </h3>
                <div class="h-72">
                    <canvas id="chartTendencia" aria-label="Tendencia de entradas"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-users mr-2"></i>
                    Usuarios registrados por mes (12 meses)
                </h3>
                <div class="h-72">
                    <canvas id="chartUsuarios" aria-label="Usuarios registrados por mes"></canvas>
                </div>
            </div>
        </div>

        {{-- Control: últimos movimientos --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-list mr-2"></i>
                Últimos pagos registrados
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-2 text-gray-600 font-medium">Fecha</th>
                            <th class="text-left py-2 text-gray-600 font-medium">Afiliado</th>
                            <th class="text-left py-2 text-gray-600 font-medium">Concepto</th>
                            <th class="text-right py-2 text-gray-600 font-medium">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimosPagos ?? [] as $p)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-2 text-gray-700">{{ $p->fecha_pago?->format('d/m/Y') }}</td>
                                <td class="py-2 text-gray-700">{{ $p->afiliado?->user?->name ?? '—' }}</td>
                                <td class="py-2 text-gray-700">{{ $p->planExequial?->nombre ?? 'Pago' }}</td>
                                <td class="py-2 text-right font-medium text-green-700">${{ number_format((float) $p->monto, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-6 text-center text-gray-500">No hay pagos recientes.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        (function() {
            var meses = @json($tendenciaMeses ?? []);
            var montos = @json($tendenciaMontos ?? []);
            var usuariosCount = @json($usuariosCount ?? []);

            var ctx1 = document.getElementById('chartTendencia');
            if (ctx1) {
                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Entradas ($)',
                            data: montos,
                            borderColor: '#5C0E2B',
                            backgroundColor: 'rgba(92, 14, 43, 0.1)',
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { callback: function(v) { return '$' + v.toLocaleString('es'); } }
                            }
                        }
                    }
                });
            }

            var ctx2 = document.getElementById('chartUsuarios');
            if (ctx2) {
                new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Usuarios',
                            data: usuariosCount,
                            backgroundColor: 'rgba(255, 215, 0, 0.6)',
                            borderColor: '#5C0E2B',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1 } }
                        }
                    }
                });
            }
        })();
    </script>
</x-admin-layout>
