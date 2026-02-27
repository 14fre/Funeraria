<?php

namespace App\Livewire\Admin\Planes;

use App\Models\PlanExequial;
use App\Services\PlanExequialService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $tipoFilter = '';
    public $estadoFilter = '';
    public $perPage = 10;
    public $sortField = 'nombre';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'tipoFilter' => ['except' => ''],
        'estadoFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

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

    public function toggleActivo($planId)
    {
        $service = app(PlanExequialService::class);
        $plan = $service->find($planId);
        $this->authorize('update', $plan);

        $plan = $service->toggleActivo($plan);
        session()->flash('success', $plan->activo
            ? 'Plan activado correctamente.'
            : 'Plan desactivado correctamente.');
    }

    public function delete($planId)
    {
        $service = app(PlanExequialService::class);
        $plan = $service->find($planId);
        $this->authorize('delete', $plan);

        try {
            $service->delete($plan);
            session()->flash('success', 'Plan eliminado correctamente.');
        } catch (ValidationException $e) {
            session()->flash('error', $e->validator->errors()->first('plan'));
        }
    }

    public function render(PlanExequialService $planExequialService)
    {
        $this->authorize('viewAny', PlanExequial::class);

        $planes = $planExequialService->listPaginated(
            [
                'search' => $this->search,
                'tipo' => $this->tipoFilter,
                'activo' => $this->estadoFilter,
            ],
            $this->sortField,
            $this->sortDirection,
            $this->perPage
        );

        $stats = $planExequialService->getStats();
        $tipos = [
            'individual' => 'Individual',
            'familiar' => 'Familiar',
            'empresarial' => 'Empresarial',
            'anticipado' => 'Anticipado',
        ];

        return view('livewire.admin.planes.index', [
            'planes' => $planes,
            'stats' => $stats,
            'tipos' => $tipos,
        ]);
    }
}

