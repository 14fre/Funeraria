<?php

namespace App\Livewire\Admin\Afiliados;

use App\Models\Afiliado;
use App\Services\AfiliadoService;
use App\Services\PlanExequialService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $estadoFilter = '';
    public $planFilter = '';
    public $perPage = 10;
    public $sortField = 'numero_afiliacion';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'estadoFilter' => ['except' => ''],
        'planFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingEstadoFilter()
    {
        $this->resetPage();
    }

    public function updatingPlanFilter()
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

    public function delete($afiliadoId)
    {
        $service = app(AfiliadoService::class);
        $afiliado = $service->find($afiliadoId);
        $this->authorize('delete', $afiliado);

        try {
            $service->delete($afiliado);
            session()->flash('success', 'Afiliado eliminado correctamente.');
        } catch (ValidationException $e) {
            session()->flash('error', $e->validator->errors()->first('afiliado'));
        }
    }

    public function render(AfiliadoService $afiliadoService, PlanExequialService $planExequialService)
    {
        $this->authorize('viewAny', Afiliado::class);

        $afiliados = $afiliadoService->listPaginated(
            [
                'search' => $this->search,
                'estado' => $this->estadoFilter,
                'plan_id' => $this->planFilter,
            ],
            $this->sortField,
            $this->sortDirection,
            $this->perPage
        );

        $stats = $afiliadoService->getStats();
        $planes = $planExequialService->getActivos();
        $estados = [
            'activo' => 'Activo',
            'suspendido' => 'Suspendido',
            'cancelado' => 'Cancelado',
            'mora' => 'Mora',
        ];

        return view('livewire.admin.afiliados.index', [
            'afiliados' => $afiliados,
            'stats' => $stats,
            'planes' => $planes,
            'estados' => $estados,
        ]);
    }
}
