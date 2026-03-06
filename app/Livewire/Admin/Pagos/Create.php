<?php

namespace App\Livewire\Admin\Pagos;

use App\Models\Afiliado;
use App\Models\Pago;
use App\Services\PagoService;
use App\Services\PlanExequialService;
use Livewire\Component;

class Create extends Component
{
    public $afiliado_id = '';
    public $plan_exequial_id = '';
    public $monto = '';
    public $metodo_pago = 'efectivo';
    public $estado = 'aprobado';
    public $fecha_pago = '';
    public $referencia = '';
    public $numero_recibo = '';
    public $observaciones = '';

    public function mount()
    {
        $this->fecha_pago = now()->toDateString();
    }

    public function updatedAfiliadoId($value)
    {
        if ($value) {
            $afiliado = Afiliado::with('planExequial')->find($value);
            if ($afiliado && $afiliado->plan_exequial_id) {
                $this->plan_exequial_id = (string) $afiliado->plan_exequial_id;
            }
        }
    }

    protected function rules(): array
    {
        return [
            'afiliado_id' => ['required', 'exists:afiliados,id'],
            'plan_exequial_id' => ['required', 'exists:planes_exequiales,id'],
            'monto' => ['required', 'numeric', 'min:1'],
            'metodo_pago' => ['required', 'in:efectivo,tarjeta,transferencia,pse,online'],
            'estado' => ['required', 'in:pendiente,aprobado,rechazado,anulado'],
            'fecha_pago' => ['required', 'date'],
            'referencia' => ['nullable', 'string', 'max:100'],
            'numero_recibo' => ['nullable', 'string', 'max:50'],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function save(PagoService $pagoService)
    {
        $this->authorize('create', Pago::class);
        $this->validate();

        try {
            $pagoService->create([
                'afiliado_id' => (int) $this->afiliado_id,
                'plan_exequial_id' => (int) $this->plan_exequial_id,
                'monto' => (float) str_replace(',', '.', $this->monto),
                'metodo_pago' => $this->metodo_pago,
                'estado' => $this->estado,
                'fecha_pago' => $this->fecha_pago,
                'referencia' => $this->referencia ?: null,
                'numero_recibo' => $this->numero_recibo ?: null,
                'observaciones' => $this->observaciones ?: null,
            ]);
            session()->flash('success', 'Pago registrado correctamente.');
            return redirect()->route('admin.pagos.index');
        } catch (\Throwable $e) {
            $this->addError('afiliado_id', $e->getMessage());
        }
    }

    public function render(PlanExequialService $planExequialService)
    {
        $this->authorize('create', Pago::class);

        $afiliados = Afiliado::with('user', 'planExequial')
            ->orderBy('numero_afiliacion')
            ->get(['id', 'user_id', 'plan_exequial_id', 'numero_afiliacion']);
        $planes = $planExequialService->getActivos();
        $metodos = [
            'efectivo' => 'Efectivo',
            'tarjeta' => 'Tarjeta',
            'transferencia' => 'Transferencia',
            'pse' => 'PSE',
            'online' => 'Online',
        ];
        $estados = [
            'pendiente' => 'Pendiente',
            'aprobado' => 'Aprobado',
            'rechazado' => 'Rechazado',
            'anulado' => 'Anulado',
        ];

        return view('livewire.admin.pagos.create', [
            'afiliados' => $afiliados,
            'planes' => $planes,
            'metodos' => $metodos,
            'estados' => $estados,
        ]);
    }
}
