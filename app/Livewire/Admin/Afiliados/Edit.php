<?php

namespace App\Livewire\Admin\Afiliados;

use App\Models\Afiliado;
use App\Models\User;
use App\Services\AfiliadoService;
use App\Services\PlanExequialService;
use App\Constants\Roles;
use Livewire\Component;

class Edit extends Component
{
    public Afiliado $afiliado;
    public $plan_exequial_id = '';
    public $fecha_afiliacion = '';
    public $estado = '';
    public $asesor_id = '';
    public $observaciones = '';

    public function mount(Afiliado $afiliado)
    {
        $this->authorize('update', $afiliado);
        $this->afiliado = $afiliado;
        $this->plan_exequial_id = $afiliado->plan_exequial_id;
        $this->fecha_afiliacion = $afiliado->fecha_afiliacion->toDateString();
        $this->estado = $afiliado->estado;
        $this->asesor_id = $afiliado->asesor_id ?? '';
        $this->observaciones = $afiliado->observaciones ?? '';
    }

    protected function rules(): array
    {
        return [
            'plan_exequial_id' => ['required', 'exists:planes_exequiales,id'],
            'fecha_afiliacion' => ['required', 'date'],
            'estado' => ['required', 'in:activo,suspendido,cancelado,mora'],
            'asesor_id' => ['nullable', 'exists:users,id'],
            'observaciones' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function update(AfiliadoService $service)
    {
        $this->authorize('update', $this->afiliado);
        $this->validate();

        $service->update($this->afiliado, [
            'plan_exequial_id' => $this->plan_exequial_id,
            'fecha_afiliacion' => $this->fecha_afiliacion,
            'estado' => $this->estado,
            'asesor_id' => $this->asesor_id ?: null,
            'observaciones' => $this->observaciones ?: null,
        ]);

        session()->flash('success', 'Afiliado actualizado correctamente.');
        return redirect()->route('admin.afiliados.index');
    }

    public function render(PlanExequialService $planExequialService)
    {
        $planes = $planExequialService->getActivos();
        $asesores = User::query()
            ->where('role_id', Roles::getId(Roles::ADMIN))
            ->orderBy('name')
            ->get(['id', 'name']);
        $estados = [
            'activo' => 'Activo',
            'suspendido' => 'Suspendido',
            'cancelado' => 'Cancelado',
            'mora' => 'Mora',
        ];

        return view('livewire.admin.afiliados.edit', [
            'planes' => $planes,
            'asesores' => $asesores,
            'estados' => $estados,
        ]);
    }
}
