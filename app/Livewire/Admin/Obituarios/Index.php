<?php

namespace App\Livewire\Admin\Obituarios;

use App\Models\Obituario;
use App\Services\ObituarioService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $publicadoFilter = '';
    public $perPage = 10;
    public $sortField = 'fecha_fallecimiento';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'publicadoFilter' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPublicadoFilter(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'desc';
        }
    }

    public function delete(int $id): void
    {
        $service = app(ObituarioService::class);
        $obituario = $service->find($id);
        $this->authorize('delete', $obituario);
        $service->delete($obituario);
        session()->flash('success', 'Obituario eliminado correctamente.');
    }

    public function render(ObituarioService $obituarioService)
    {
        $this->authorize('viewAny', Obituario::class);

        $obituarios = $obituarioService->listPaginated(
            [
                'search' => $this->search,
                'publicado' => $this->publicadoFilter,
            ],
            $this->sortField,
            $this->sortDirection,
            $this->perPage
        );

        $stats = $obituarioService->getStats();

        return view('livewire.admin.obituarios.index', [
            'obituarios' => $obituarios,
            'stats' => $stats,
        ]);
    }
}
