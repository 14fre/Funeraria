<?php

namespace App\Livewire\Admin\Afiliados;

use App\Models\Afiliado;
use App\Models\User;
use App\Services\AfiliadoService;
use App\Services\PlanExequialService;
use App\Constants\Roles;
use Livewire\Component;

class Create extends Component
{
    public $user_id = '';
    public $plan_exequial_id = '';
    public $fecha_afiliacion = '';
    public $estado = 'activo';
    public $asesor_id = '';
    public $observaciones = '';

    public function mount()
    {
        $this->fecha_afiliacion = now()->toDateString();
    }

    protected function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'plan_exequial_id' => ['required', 'exists:planes_exequiales,id'],
            'fecha_afiliacion' => ['required', 'date'],
            'estado' => ['required', 'in:activo,suspendido,cancelado,mora'],
            'asesor_id' => ['nullable', 'exists:users,id'],
            'observaciones' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function save(AfiliadoService $service)
    {
        $this->authorize('create', Afiliado::class);
        $this->validate();

        try {
            $service->create([
                'user_id' => $this->user_id,
                'plan_exequial_id' => $this->plan_exequial_id,
                'fecha_afiliacion' => $this->fecha_afiliacion,
                'estado' => $this->estado,
                'asesor_id' => $this->asesor_id ?: null,
                'observaciones' => $this->observaciones ?: null,
            ]);
            session()->flash('success', 'Afiliado creado correctamente.');
            return redirect()->route('admin.afiliados.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->addError('user_id', $e->validator->errors()->first('user_id'));
        }
    }

    public function render(PlanExequialService $planExequialService)
    {
        $this->authorize('create', Afiliado::class);

        $clientes = User::query()
            ->where('role_id', Roles::getId(Roles::CLIENTE))
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
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

        return view('livewire.admin.afiliados.create', [
            'clientes' => $clientes,
            'planes' => $planes,
            'asesores' => $asesores,
            'estados' => $estados,
        ]);
    }
}
