<?php

namespace App\Livewire\Admin\Planes;

use App\Models\PlanExequial;
use App\Services\PlanExequialService;
use Livewire\Component;

class Create extends Component
{
    public $nombre = '';
    public $descripcion = '';
    public $tipo = 'individual';
    public $max_beneficiarios = 1;
    public $precio_mensual = 0;
    public $precio_anual = 0;
    public $servicios_incluidos = [];
    public $activo = true;

    public $serviciosDisponibles = [
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

    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:255', 'unique:planes_exequiales,nombre'],
            'descripcion' => ['nullable', 'string'],
            'tipo' => ['required', 'in:individual,familiar,empresarial,anticipado'],
            'max_beneficiarios' => ['required', 'integer', 'min:1', 'max:100'],
            'precio_mensual' => ['required', 'numeric', 'min:0'],
            'precio_anual' => ['required', 'numeric', 'min:0'],
            'servicios_incluidos' => ['nullable', 'array'],
            'activo' => ['boolean'],
        ];
    }

    public function updatedTipo()
    {
        // Ajustar max_beneficiarios según el tipo
        $this->max_beneficiarios = match($this->tipo) {
            'individual' => 1,
            'familiar' => 5,
            'empresarial' => 50,
            'anticipado' => 10,
            default => 1,
        };
    }

    public function toggleServicio($servicio)
    {
        if (in_array($servicio, $this->servicios_incluidos)) {
            $this->servicios_incluidos = array_values(array_diff($this->servicios_incluidos, [$servicio]));
        } else {
            $this->servicios_incluidos[] = $servicio;
        }
    }

    public function save(PlanExequialService $service)
    {
        $this->authorize('create', PlanExequial::class);
        $this->validate();

        $service->create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tipo' => $this->tipo,
            'max_beneficiarios' => $this->max_beneficiarios,
            'precio_mensual' => $this->precio_mensual,
            'precio_anual' => $this->precio_anual,
            'servicios_incluidos' => $this->servicios_incluidos,
            'activo' => $this->activo,
        ]);

        session()->flash('success', 'Plan exequial creado correctamente.');
        return redirect()->route('admin.planes.index');
    }

    public function render()
    {
        $this->authorize('create', PlanExequial::class);
        return view('livewire.admin.planes.create');
    }
}

