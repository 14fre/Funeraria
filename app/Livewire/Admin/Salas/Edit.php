<?php

namespace App\Livewire\Admin\Salas;

use App\Models\SalaVelacion;
use App\Services\SalaVelacionService;
use Livewire\Component;

class Edit extends Component
{
    public SalaVelacion $sala;
    public $nombre = '';
    public $descripcion = '';
    public $capacidad = 20;
    public $ubicacion = '';
    public $servicios_incluidos = '';
    public $precio_hora = 0;
    public $estado = 'disponible';

    public function mount(SalaVelacion $salaVelacion)
    {
        $this->sala = $salaVelacion;
        $this->nombre = $salaVelacion->nombre;
        $this->descripcion = $salaVelacion->descripcion ?? '';
        $this->capacidad = $salaVelacion->capacidad;
        $this->ubicacion = $salaVelacion->ubicacion ?? '';
        $this->servicios_incluidos = $salaVelacion->servicios_incluidos ?? '';
        $this->precio_hora = $salaVelacion->precio_hora;
        $this->estado = $salaVelacion->estado;
    }

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:2000'],
            'capacidad' => ['required', 'integer', 'min:1'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'servicios_incluidos' => ['nullable', 'string', 'max:1000'],
            'precio_hora' => ['nullable', 'numeric', 'min:0'],
            'estado' => ['required', 'in:disponible,ocupada,mantenimiento,fuera_servicio'],
        ];
    }

    public function save(SalaVelacionService $service)
    {
        $this->authorize('update', $this->sala);
        $this->validate();
        $service->update($this->sala, [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion ?: null,
            'capacidad' => $this->capacidad,
            'ubicacion' => $this->ubicacion ?: null,
            'servicios_incluidos' => $this->servicios_incluidos ?: null,
            'precio_hora' => $this->precio_hora ?: 0,
            'estado' => $this->estado,
        ]);
        session()->flash('success', 'Sala actualizada correctamente.');
        return $this->redirect(route('admin.salas.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.salas.edit');
    }
}
