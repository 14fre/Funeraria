<?php

namespace App\Livewire\Admin\Inventario;

use App\Models\Inventario;
use App\Services\InventarioService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $tipoFilter = '';
    public $estadoFilter = '';
    public $bajoStockFilter = '';
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

    public function delete($id)
    {
        $service = app(InventarioService::class);
        $item = $service->find($id);
        $this->authorize('delete', $item);
        $service->delete($item);
        session()->flash('success', 'Ítem de inventario eliminado correctamente.');
    }

    public function render(InventarioService $inventarioService)
    {
        $this->authorize('viewAny', Inventario::class);

        $items = $inventarioService->listPaginated(
            [
                'search' => $this->search,
                'tipo' => $this->tipoFilter,
                'estado' => $this->estadoFilter,
                'bajo_stock' => $this->bajoStockFilter,
            ],
            $this->sortField,
            $this->sortDirection,
            $this->perPage
        );

        $stats = $inventarioService->getStats();
        $tipos = [
            'urna' => 'Urna',
            'ataud' => 'Ataúd',
            'flores' => 'Flores',
            'velas' => 'Velas',
            'otros' => 'Otros',
        ];
        $estados = [
            'disponible' => 'Disponible',
            'agotado' => 'Agotado',
            'discontinuado' => 'Discontinuado',
        ];

        return view('livewire.admin.inventario.index', [
            'items' => $items,
            'stats' => $stats,
            'tipos' => $tipos,
            'estados' => $estados,
        ]);
    }
}
