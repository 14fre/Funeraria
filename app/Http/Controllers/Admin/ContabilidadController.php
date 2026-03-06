<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContabilidadController extends Controller
{
    /**
     * Sanear mes y año (evitar que query ?imprimir=1 se pegue al valor).
     */
    private function sanitizeMesAnio(Request $request): array
    {
        $mes = (int) preg_replace('/[^0-9].*$/', '', (string) $request->get('mes', now()->month));
        $anio = (int) preg_replace('/[^0-9].*$/', '', (string) $request->get('anio', now()->year));
        $mes = $mes >= 1 && $mes <= 12 ? $mes : (int) now()->month;
        $anio = $anio >= 2000 && $anio <= 2100 ? $anio : (int) now()->year;
        return [$mes, $anio];
    }

    /**
     * Vista principal: resumen, gráficos y control.
     */
    public function index(Request $request): View
    {
        [$mes, $anio] = $this->sanitizeMesAnio($request);
        $inicio = Carbon::createFromDate($anio, $mes, 1)->startOfMonth();
        $fin = $inicio->copy()->endOfMonth();

        $entradas = (float) Pago::where('estado', 'aprobado')
            ->whereBetween('fecha_pago', [$inicio, $fin])
            ->sum('monto');

        $cantidadPagos = Pago::where('estado', 'aprobado')
            ->whereBetween('fecha_pago', [$inicio, $fin])
            ->count();

        // Últimos 12 meses para gráfico de tendencia
        $tendenciaMeses = [];
        $tendenciaMontos = [];
        for ($i = 11; $i >= 0; $i--) {
            $f = Carbon::now()->subMonths($i);
            $inicioMes = $f->copy()->startOfMonth();
            $finMes = $f->copy()->endOfMonth();
            $total = (float) Pago::where('estado', 'aprobado')
                ->whereBetween('fecha_pago', [$inicioMes, $finMes])
                ->sum('monto');
            $tendenciaMeses[] = $inicioMes->translatedFormat('M Y');
            $tendenciaMontos[] = round($total, 0);
        }

        // Últimos pagos para "control" reciente
        $ultimosPagos = Pago::with('afiliado.user', 'planExequial')
            ->where('estado', 'aprobado')
            ->orderByDesc('fecha_pago')
            ->limit(10)
            ->get();

        // Usuarios registrados por mes (últimos 12 meses) para segunda gráfica
        $usuariosMeses = [];
        $usuariosCount = [];
        for ($i = 11; $i >= 0; $i--) {
            $f = Carbon::now()->subMonths($i);
            $inicioMes = $f->copy()->startOfMonth();
            $finMes = $f->copy()->endOfMonth();
            $count = User::whereBetween('created_at', [$inicioMes, $finMes])->count();
            $usuariosMeses[] = $inicioMes->translatedFormat('M Y');
            $usuariosCount[] = $count;
        }

        // Años disponibles para reportes: desde el primer registro (usuario o pago) hasta hoy
        $primerUsuario = User::min('created_at');
        $primerPago = Pago::min('fecha_pago');
        $primerAnio = now()->year;
        if ($primerUsuario) {
            $primerAnio = min($primerAnio, Carbon::parse($primerUsuario)->year);
        }
        if ($primerPago) {
            $primerAnio = min($primerAnio, Carbon::parse($primerPago)->year);
        }
        $aniosDisponibles = range(now()->year, max(2000, $primerAnio));

        return view('admin.contabilidad.index', [
            'entradas' => $entradas,
            'cantidadPagos' => $cantidadPagos,
            'mes' => $mes,
            'anio' => $anio,
            'nombreMes' => $inicio->translatedFormat('F Y'),
            'tendenciaMeses' => $tendenciaMeses,
            'tendenciaMontos' => $tendenciaMontos,
            'ultimosPagos' => $ultimosPagos,
            'usuariosMeses' => $usuariosMeses,
            'usuariosCount' => $usuariosCount,
            'aniosDisponibles' => $aniosDisponibles,
        ]);
    }

    /**
     * Reporte mensual: pantalla o imprimir/PDF.
     */
    public function reporteMensual(Request $request): View
    {
        [$mes, $anio] = $this->sanitizeMesAnio($request);
        $inicio = Carbon::createFromDate($anio, $mes, 1)->startOfMonth();
        $fin = $inicio->copy()->endOfMonth();

        $pagos = Pago::with('afiliado.user', 'planExequial')
            ->where('estado', 'aprobado')
            ->whereBetween('fecha_pago', [$inicio, $fin])
            ->orderBy('fecha_pago')
            ->get();

        $totalEntradas = $pagos->sum('monto');
        $nombreMes = $inicio->translatedFormat('F Y');

        return view('admin.contabilidad.reporte-mensual', [
            'pagos' => $pagos,
            'totalEntradas' => $totalEntradas,
            'nombreMes' => $nombreMes,
            'inicio' => $inicio,
            'fin' => $fin,
            'tipo' => 'mensual',
        ]);
    }

    /**
     * Reporte anual: resumen por mes del año seleccionado.
     */
    public function reporteAnual(Request $request): View
    {
        $anio = (int) preg_replace('/[^0-9].*$/', '', (string) $request->get('anio', now()->year));
        $anio = $anio >= 2000 && $anio <= 2100 ? $anio : (int) now()->year;

        $mesesData = [];
        $totalAnual = 0;
        for ($m = 1; $m <= 12; $m++) {
            $inicio = Carbon::createFromDate($anio, $m, 1)->startOfMonth();
            $fin = $inicio->copy()->endOfMonth();
            $total = (float) Pago::where('estado', 'aprobado')
                ->whereBetween('fecha_pago', [$inicio, $fin])
                ->sum('monto');
            $mesesData[] = [
                'nombre' => $inicio->translatedFormat('F'),
                'total' => $total,
                'cantidad' => Pago::where('estado', 'aprobado')->whereBetween('fecha_pago', [$inicio, $fin])->count(),
            ];
            $totalAnual += $total;
        }

        return view('admin.contabilidad.reporte-anual', [
            'mesesData' => $mesesData,
            'totalAnual' => $totalAnual,
            'anio' => $anio,
            'tipo' => 'anual',
        ]);
    }
}
