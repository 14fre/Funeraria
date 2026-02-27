<?php

namespace App\Livewire\Admin\Servicios;

use App\Models\ServicioFunerario;
use App\Models\User;
use App\Services\BeneficiarioService;
use App\Services\ServicioFunerarioService;
use App\Services\AfiliadoService;
use App\Constants\Roles;
use Livewire\Component;

class Create extends Component
{
    public $afiliado_id = '';
    public $beneficiario_id = '';
    public $tipo = 'velacion';
    public $estado = 'solicitado';
    public $fecha_solicitud = '';
    public $fecha_servicio = '';
    public $hora_servicio = '';
    public $coordinador_id = '';
    public $observaciones = '';
    public $costo_adicional = 0;

    public function mount()
    {
        $this->fecha_solicitud = now()->toDateString();
    }

    protected function rules(): array
    {
        return [
            'afiliado_id' => ['required', 'exists:afiliados,id'],
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

    public function save(ServicioFunerarioService $service)
    {
        $this->authorize('create', ServicioFunerario::class);
        $this->validate();
        $service->create([
            'afiliado_id' => $this->afiliado_id,
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
        session()->flash('success', 'Servicio funerario registrado.');
        return redirect()->route('admin.servicios.index');
    }

    public function render(AfiliadoService $afiliadoService, BeneficiarioService $beneficiarioService)
    {
        $this->authorize('create', ServicioFunerario::class);
        $afiliadosPaginator = $afiliadoService->listPaginated([], 'numero_afiliacion', 'asc', 500);
        $beneficiarios = $this->afiliado_id ? $beneficiarioService->getByAfiliado((int) $this->afiliado_id) : collect();
        $coordinadores = User::where('role_id', Roles::getId(Roles::ADMIN))->orderBy('name')->get(['id', 'name']);
        $tipos = ['velacion' => 'Velación', 'velacion_virtual' => 'Velación Virtual', 'cremacion' => 'Cremación', 'traslado_nacional' => 'Traslado Nacional', 'traslado_internacional' => 'Traslado Internacional'];
        $estados = ['solicitado' => 'Solicitado', 'programado' => 'Programado', 'en_proceso' => 'En proceso', 'completado' => 'Completado', 'cancelado' => 'Cancelado'];
        return view('livewire.admin.servicios.create', compact('afiliadosPaginator', 'beneficiarios', 'coordinadores', 'tipos', 'estados'));
    }
}
