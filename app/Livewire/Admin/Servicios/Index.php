<?php

namespace App\Livewire\Admin\Servicios;

use App\Models\ServicioFunerario;
use App\Services\AfiliadoService;
use App\Services\ServicioFunerarioService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $estadoFilter = '';
    public $tipoFilter = '';
    public $perPage = 10;
    public $sortField = 'fecha_solicitud';
    public $sortDirection = 'desc';

    protected $queryString = ['search' => ['except' => ''], 'estadoFilter' => ['except' => ''], 'tipoFilter' => ['except' => '']];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingEstadoFilter() { $this->resetPage(); }
    public function updatingTipoFilter() { $this->resetPage(); }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function delete($id, ServicioFunerarioService $service)
    {
        $s = $service->find($id);
        $this->authorize('delete', $s);
        $service->delete($s);
        session()->flash('success', 'Servicio eliminado.');
    }

    public function render(ServicioFunerarioService $service, AfiliadoService $afiliadoService)
    {
        $this->authorize('viewAny', ServicioFunerario::class);
        $servicios = $service->listPaginated(
            ['search' => $this->search, 'estado' => $this->estadoFilter, 'tipo' => $this->tipoFilter],
            $this->sortField,
            $this->sortDirection,
            $this->perPage
        );
        $stats = $service->getStats();
        $tipos = ['velacion' => 'Velación', 'velacion_virtual' => 'Velación Virtual', 'cremacion' => 'Cremación', 'traslado_nacional' => 'Traslado Nacional', 'traslado_internacional' => 'Traslado Internacional'];
        $estados = ['solicitado' => 'Solicitado', 'programado' => 'Programado', 'en_proceso' => 'En proceso', 'completado' => 'Completado', 'cancelado' => 'Cancelado'];
        return view('livewire.admin.servicios.index', compact('servicios', 'stats', 'tipos', 'estados'));
    }
}
