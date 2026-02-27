<?php

namespace App\Livewire\Admin\Vehiculos;

use App\Models\User;
use App\Models\Vehiculo;
use App\Services\VehiculoService;
use Livewire\Component;

class Create extends Component
{
    public string $tipo = 'carroza';
    public string $placa = '';
    public string $marca = '';
    public string $modelo = '';
    public string $ano = '';
    public string $capacidad = '4';
    public string $kilometraje = '0';
    public string $estado = 'disponible';
    public string $conductor_id = '';
    public string $observaciones = '';

    protected function rules(): array
    {
        $currentYear = (int) date('Y');
        return [
            'tipo' => ['required', 'in:carroza,ambulancia,van,microbus'],
            'placa' => ['required', 'string', 'max:20', 'unique:vehiculos,placa'],
            'marca' => ['required', 'string', 'max:100'],
            'modelo' => ['required', 'string', 'max:100'],
            'ano' => ['required', 'integer', 'min:1990', 'max:' . ($currentYear + 1)],
            'capacidad' => ['required', 'integer', 'min:1', 'max:50'],
            'kilometraje' => ['required', 'integer', 'min:0'],
            'estado' => ['required', 'in:disponible,en_servicio,mantenimiento,fuera_servicio'],
            'conductor_id' => ['nullable', 'exists:users,id'],
            'observaciones' => ['nullable', 'string', 'max:2000'],
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'conductor_id' => 'conductor',
        ];
    }

    public function save(VehiculoService $service)
    {
        $this->authorize('create', Vehiculo::class);
        $this->validate();
        $service->create([
            'tipo' => $this->tipo,
            'placa' => $this->placa,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'ano' => (int) $this->ano,
            'capacidad' => (int) $this->capacidad,
            'kilometraje' => (int) $this->kilometraje,
            'estado' => $this->estado,
            'conductor_id' => $this->conductor_id ? (int) $this->conductor_id : null,
            'observaciones' => $this->observaciones ?: null,
        ]);
        session()->flash('success', 'Vehículo registrado correctamente.');
        return $this->redirect(route('admin.vehiculos.index'), navigate: true);
    }

    public function render()
    {
        $conductores = User::query()->orderBy('name')->get(['id', 'name', 'email']);
        return view('livewire.admin.vehiculos.create', compact('conductores'));
    }
}
