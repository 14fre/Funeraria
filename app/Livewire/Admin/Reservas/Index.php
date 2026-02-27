<?php

namespace App\Livewire\Admin\Reservas;

use App\Models\Reserva;
use App\Services\ReservaService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $tipoFilter = '';
    public $estadoFilter = '';
    public $fechaDesde = '';
    public $fechaHasta = '';
    public $perPage = 10;
    public $sortField = 'fecha_inicio';
    public $sortDirection = 'desc';

    protected $queryString = [
        'tipoFilter' => ['except' => ''],
        'estadoFilter' => ['except' => ''],
    ];

    public function updatingTipoFilter()
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
        $service = app(ReservaService::class);
        $reserva = $service->find($id);
        $this->authorize('delete', $reserva);
        $service->delete($reserva);
        session()->flash('success', 'Reserva eliminada correctamente.');
    }

    public function render(ReservaService $reservaService)
    {
        $this->authorize('viewAny', Reserva::class);

        $reservas = $reservaService->listPaginated(
            [
                'tipo_recurso' => $this->tipoFilter,
                'estado' => $this->estadoFilter,
                'fecha_desde' => $this->fechaDesde ?: null,
                'fecha_hasta' => $this->fechaHasta ?: null,
            ],
            $this->sortField,
            $this->sortDirection,
            $this->perPage
        );

        $stats = $reservaService->getStats();
        $estados = [
            'reservada' => 'Reservada',
            'confirmada' => 'Confirmada',
            'cancelada' => 'Cancelada',
            'completada' => 'Completada',
        ];

        return view('livewire.admin.reservas.index', [
            'reservas' => $reservas,
            'stats' => $stats,
            'estados' => $estados,
        ]);
    }
}
