<?php

namespace App\Livewire\Admin\Vehiculos;

use App\Models\User;
use App\Models\Vehiculo;
use App\Services\VehiculoService;
use Livewire\Component;

class Edit extends Component
{
    public Vehiculo $vehiculo;
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

    public function mount(Vehiculo $vehiculo): void
    {
        $this->vehiculo = $vehiculo;
        $this->tipo = $vehiculo->tipo;
        $this->placa = $vehiculo->placa;
        $this->marca = $vehiculo->marca;
        $this->modelo = $vehiculo->modelo;
        $this->ano = (string) $vehiculo->ano;
        $this->capacidad = (string) $vehiculo->capacidad;
        $this->kilometraje = (string) $vehiculo->kilometraje;
        $this->estado = $vehiculo->estado;
        $this->conductor_id = $vehiculo->conductor_id ? (string) $vehiculo->conductor_id : '';
        $this->observaciones = $vehiculo->observaciones ?? '';
    }

    protected function rules(): array
    {
        $currentYear = (int) date('Y');
        return [
            'tipo' => ['required', 'in:carroza,ambulancia,van,microbus'],
            'placa' => ['required', 'string', 'max:20', 'unique:vehiculos,placa,' . $this->vehiculo->id],
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
        $this->authorize('update', $this->vehiculo);
        $this->validate();
        $service->update($this->vehiculo, [
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
        session()->flash('success', 'Vehículo actualizado correctamente.');
        return $this->redirect(route('admin.vehiculos.index'), navigate: true);
    }

    public function render()
    {
        $conductores = User::query()->orderBy('name')->get(['id', 'name', 'email']);
        return view('livewire.admin.vehiculos.edit', compact('conductores'));
    }
}
