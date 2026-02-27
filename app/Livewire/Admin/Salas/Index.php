<?php

namespace App\Livewire\Admin\Salas;

use App\Models\SalaVelacion;
use App\Services\SalaVelacionService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $estadoFilter = '';
    public $perPage = 10;
    public $sortField = 'nombre';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'estadoFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingEstadoFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function delete($id)
    {
        $service = app(SalaVelacionService::class);
        $sala = $service->find($id);
        $this->authorize('delete', $sala);
        $service->delete($sala);
        session()->flash('success', 'Sala eliminada correctamente.');
    }

    public function render(SalaVelacionService $salaVelacionService)
    {
        $this->authorize('viewAny', SalaVelacion::class);

        $salas = $salaVelacionService->listPaginated(
            [
                'search' => $this->search,
                'estado' => $this->estadoFilter,
            ],
            $this->sortField,
            $this->sortDirection,
            $this->perPage
        );

        $stats = $salaVelacionService->getStats();
        $estados = [
            'disponible' => 'Disponible',
            'ocupada' => 'Ocupada',
            'mantenimiento' => 'Mantenimiento',
            'fuera_servicio' => 'Fuera de servicio',
        ];

        return view('livewire.admin.salas.index', [
            'salas' => $salas,
            'stats' => $stats,
            'estados' => $estados,
        ]);
    }
}
