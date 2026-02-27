<?php

namespace App\Livewire\Admin\Servicios;

use App\Models\ServicioFunerario;
use App\Models\User;
use App\Services\BeneficiarioService;
use App\Services\ServicioFunerarioService;
use App\Constants\Roles;
use Livewire\Component;

class Edit extends Component
{
    public ServicioFunerario $servicio;
    public $beneficiario_id = '';
    public $tipo = '';
    public $estado = '';
    public $fecha_solicitud = '';
    public $fecha_servicio = '';
    public $hora_servicio = '';
    public $coordinador_id = '';
    public $observaciones = '';
    public $costo_adicional = 0;

    public function mount(ServicioFunerario $servicio)
    {
        $this->authorize('update', $servicio);
        $this->servicio = $servicio;
        $this->beneficiario_id = $servicio->beneficiario_id ?? '';
        $this->tipo = $servicio->tipo;
        $this->estado = $servicio->estado;
        $this->fecha_solicitud = $servicio->fecha_solicitud->toDateString();
        $this->fecha_servicio = $servicio->fecha_servicio?->toDateString() ?? '';
        $this->hora_servicio = $servicio->hora_servicio ? $servicio->hora_servicio->format('H:i') : '';
        $this->coordinador_id = $servicio->coordinador_id ?? '';
        $this->observaciones = $servicio->observaciones ?? '';
        $this->costo_adicional = $servicio->costo_adicional ?? 0;
    }

    protected function rules(): array
    {
        return [
            'beneficiario_id' => ['nullable', 'exists:beneficiarios,id'],
            'tipo' => ['required', 'in:velacion,velacion_virtual,cremacion,traslado_nacional,traslado_internacional'],
            'estado' => ['required', 'in:solicitado,programado,en_proceso,completado,cancelado'],
            'fecha_solicitud' => ['required', 'date'],
            'fecha_servicio' => ['nullable', 'date'],
            'hora_servicio' => ['nullable'],
            'coordinador_id' => ['nullable', 'exists:users,id'],
            'observaciones' => ['nullable', 'string', 'max:2000'],
            'costo_adicional' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function update(ServicioFunerarioService $service)
    {
        $this->authorize('update', $this->servicio);
        $this->validate();
        $service->update($this->servicio, [
            'beneficiario_id' => $this->beneficiario_id ?: null,
            'tipo' => $this->tipo,
            'estado' => $this->estado,
            'fecha_solicitud' => $this->fecha_solicitud,
            'fecha_servicio' => $this->fecha_servicio ?: null,
            'hora_servicio' => $this->hora_servicio ?: null,
            'coordinador_id' => $this->coordinador_id ?: null,
            'observaciones' => $this->observaciones ?: null,
            'costo_adicional' => (float) ($this->costo_adicional ?: 0),
        ]);
        session()->flash('success', 'Servicio actualizado.');
        return redirect()->route('admin.servicios.index');
    }

    public function render(BeneficiarioService $beneficiarioService)
    {
        $beneficiarios = $beneficiarioService->getByAfiliado($this->servicio->afiliado_id);
        $coordinadores = User::where('role_id', Roles::getId(Roles::ADMIN))->orderBy('name')->get(['id', 'name']);
        $tipos = ['velacion' => 'Velación', 'velacion_virtual' => 'Velación Virtual', 'cremacion' => 'Cremación', 'traslado_nacional' => 'Traslado Nacional', 'traslado_internacional' => 'Traslado Internacional'];
        $estados = ['solicitado' => 'Solicitado', 'programado' => 'Programado', 'en_proceso' => 'En proceso', 'completado' => 'Completado', 'cancelado' => 'Cancelado'];
        return view('livewire.admin.servicios.edit', compact('beneficiarios', 'coordinadores', 'tipos', 'estados'));
    }
}
