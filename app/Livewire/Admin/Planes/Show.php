<?php

namespace App\Livewire\Admin\Planes;

use App\Models\PlanExequial;
use Livewire\Component;

class Show extends Component
{
    public PlanExequial $plan;

    public function mount(PlanExequial $plan)
    {
        $this->authorize('view', $plan);
        $this->plan = $plan->load('afiliados');
    }

    public function render()
    {
        $stats = [
            'total_afiliados' => $this->plan->afiliados()->count(),
            'afiliados_activos' => $this->plan->afiliados()->where('estado', 'activo')->count(),
            'ingresos_mensuales' => $this->plan->pagos()
                ->where('estado', 'aprobado')
                ->whereMonth('fecha_pago', now()->month)
                ->whereYear('fecha_pago', now()->year)
                ->sum('monto'),
        ];

        $serviciosLabels = [
            'velacion' => 'Velación',
            'velacion_virtual' => 'Velación Virtual',
            'cremacion' => 'Cremación',
            'traslado_nacional' => 'Traslado Nacional',
            'traslado_internacional' => 'Traslado Internacional',
            'urna_basica' => 'Urna Básica',
            'urna_premium' => 'Urna Premium',
            'flores' => 'Flores',
            'velas' => 'Velas',
            'sala_vip' => 'Sala VIP',
        ];

        return view('livewire.admin.planes.show', [
            'stats' => $stats,
            'serviciosLabels' => $serviciosLabels,
        ]);
    }
}

