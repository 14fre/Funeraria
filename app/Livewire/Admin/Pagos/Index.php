<?php

namespace App\Livewire\Admin\Pagos;

use App\Models\Pago;
use App\Services\PagoService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $estadoFilter = '';
    public $fechaDesde = '';
    public $fechaHasta = '';
    public $perPage = 15;
    public $sortField = 'fecha_pago';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'estadoFilter' => ['except' => ''],
        'fechaDesde' => ['except' => ''],
        'fechaHasta' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingEstadoFilter()
    {
        $this->resetPage();
    }

    public function updatingFechaDesde()
    {
        $this->resetPage();
    }

    public function updatingFechaHasta()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'desc';
        }
    }

    public function anular($pagoId)
    {
        $service = app(PagoService::class);
        $pago = $service->find($pagoId);
        $this->authorize('update', $pago);
        if ($pago->estado === 'anulado') {
            session()->flash('error', 'El pago ya está anulado.');
            return;
        }
        $service->updateEstado($pago, 'anulado');
        session()->flash('success', 'Pago anulado correctamente.');
    }

    public function render(PagoService $pagoService)
    {
        $this->authorize('viewAny', Pago::class);

        $pagos = $pagoService->listPaginated(
            [
                'search' => $this->search,
                'estado' => $this->estadoFilter,
                'fecha_desde' => $this->fechaDesde ?: null,
                'fecha_hasta' => $this->fechaHasta ?: null,
            ],
            $this->sortField,
            $this->sortDirection,
            $this->perPage
        );

        $stats = $pagoService->getStats();
        $estados = [
            'pendiente' => 'Pendiente',
            'aprobado' => 'Aprobado',
            'rechazado' => 'Rechazado',
            'anulado' => 'Anulado',
        ];

        return view('livewire.admin.pagos.index', [
            'pagos' => $pagos,
            'stats' => $stats,
            'estados' => $estados,
        ]);
    }
}
