<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-inbox mr-2"></i>
            Solicitudes de afiliación
        </h2>
    </x-slot>
    <div class="py-6">
        <!-- Pendientes -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 border-b bg-yellow-50">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-clock text-yellow-600 mr-2"></i>
                    Pendientes ({{ $pendientes->count() }})
                </h3>
            </div>
            @if ($pendientes->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Plan solicitado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mensaje</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($pendientes as $s)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $s->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $s->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $s->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $s->planExequial->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $s->mensaje ?? '—' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <form id="aprobar-form-{{ $s->id }}" action="{{ route('admin.solicitudes-afiliacion.aprobar', $s) }}" method="POST" class="inline-block mr-2">
                                        @csrf
                                        <button type="button" class="btn-aprobar-swal text-green-600 hover:text-green-800 font-medium text-sm" data-form-id="aprobar-form-{{ $s->id }}" data-nombre="{{ $s->user->name }}" data-plan="{{ $s->planExequial->nombre }}">Aprobar y afiliar</button>
                                    </form>
                                    <form id="rechazar-form-{{ $s->id }}" action="{{ route('admin.solicitudes-afiliacion.rechazar', $s) }}" method="POST" class="inline-block">
                                        @csrf
                                        <input type="text" name="observaciones" placeholder="Motivo (opcional)" class="text-sm border rounded px-2 py-1 mr-2 w-40">
                                        <button type="button" class="btn-rechazar-swal text-red-600 hover:text-red-800 font-medium text-sm" data-form-id="rechazar-form-{{ $s->id }}">Rechazar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-8 text-center text-gray-500">No hay solicitudes pendientes.</div>
            @endif
        </div>

        <!-- Recientes aprobadas / rechazadas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-4 py-3 border-b bg-green-50">
                    <h3 class="font-semibold text-gray-800">Recientes aprobadas</h3>
                </div>
                @if ($aprobadas->count() > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach ($aprobadas as $s)
                            <li class="px-4 py-3 text-sm">
                                <span class="font-medium">{{ $s->user->name }}</span> → {{ $s->planExequial->nombre }}
                                <span class="text-gray-500 text-xs">{{ $s->responded_at?->format('d/m/Y') }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="p-4 text-gray-500 text-sm">Ninguna aún.</p>
                @endif
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-4 py-3 border-b bg-red-50">
                    <h3 class="font-semibold text-gray-800">Recientes rechazadas</h3>
                </div>
                @if ($rechazadas->count() > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach ($rechazadas as $s)
                            <li class="px-4 py-3 text-sm">
                                <span class="font-medium">{{ $s->user->name }}</span> → {{ $s->planExequial->nombre }}
                                <span class="text-gray-500 text-xs">{{ $s->responded_at?->format('d/m/Y') }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="p-4 text-gray-500 text-sm">Ninguna aún.</p>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-aprobar-swal').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var form = document.getElementById(this.getAttribute('data-form-id'));
                    var nombre = this.getAttribute('data-nombre');
                    var plan = this.getAttribute('data-plan');
                    Swal.fire({
                        title: '¿Aprobar y afiliar?',
                        html: 'Se afiliará a <strong>' + nombre + '</strong> al plan <strong>' + plan + '</strong>.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#16a34a',
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Sí, aprobar'
                    }).then(function(result) {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
            document.querySelectorAll('.btn-rechazar-swal').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var form = document.getElementById(this.getAttribute('data-form-id'));
                    Swal.fire({
                        title: '¿Rechazar esta solicitud?',
                        text: 'La solicitud será marcada como rechazada.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Sí, rechazar'
                    }).then(function(result) {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        });
    </script>
    @endpush
</x-admin-layout>
