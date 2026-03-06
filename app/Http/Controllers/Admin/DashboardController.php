<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Afiliado;
use App\Models\Pago;
use App\Models\PlanExequial;
use App\Models\ServicioFunerario;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $now = Carbon::now();
        $inicioMes = $now->copy()->startOfMonth();
        $finMes = $now->copy()->endOfMonth();

        $totalUsuarios = User::count();
        $afiliadosActivos = Afiliado::where('estado', 'activo')->count();
        $ingresosMensuales = (float) Pago::where('estado', 'aprobado')
            ->whereBetween('fecha_pago', [$inicioMes, $finMes])
            ->sum('monto');
        $serviciosPendientes = ServicioFunerario::whereIn('estado', ['solicitado', 'programado', 'en_proceso'])->count();

        $porPlan = PlanExequial::query()
            ->where('activo', true)
            ->withCount(['afiliados' => function ($q) {
                $q->where('estado', 'activo');
            }])
            ->orderByDesc('afiliados_count')
            ->get(['id', 'nombre', 'precio_mensual']);

        $actividadReciente = $this->actividadReciente();

        return view('admin.dashboard', [
            'totalUsuarios' => $totalUsuarios,
            'afiliadosActivos' => $afiliadosActivos,
            'ingresosMensuales' => $ingresosMensuales,
            'serviciosPendientes' => $serviciosPendientes,
            'porPlan' => $porPlan,
            'actividadReciente' => $actividadReciente,
        ]);
    }

    private function actividadReciente(): array
    {
        $pagos = Pago::with('afiliado.user')
            ->where('estado', 'aprobado')
            ->orderByDesc('fecha_pago')
            ->limit(5)
            ->get();

        $items = [];
        foreach ($pagos as $pago) {
            $nombre = $pago->afiliado?->user?->name ?? 'Afiliado';
            $items[] = [
                'tipo' => 'pago',
                'texto' => 'Pago $' . number_format((float) $pago->monto, 0, ',', '.') . ' - ' . $nombre,
                'fecha' => $pago->fecha_pago?->format('d/m/Y'),
            ];
        }

        $servicios = ServicioFunerario::with('afiliado.user')
            ->orderByDesc('fecha_solicitud')
            ->limit(3)
            ->get();

        foreach ($servicios as $s) {
            $nombre = $s->afiliado?->user?->name ?? 'Afiliado';
            $items[] = [
                'tipo' => 'servicio',
                'texto' => 'Servicio ' . ($s->tipo ?? '') . ' - ' . $nombre,
                'fecha' => $s->fecha_solicitud?->format('d/m/Y'),
            ];
        }

        usort($items, function ($a, $b) {
            return strcmp($b['fecha'] ?? '', $a['fecha'] ?? '');
        });

        return array_slice($items, 0, 8);
    }
}
