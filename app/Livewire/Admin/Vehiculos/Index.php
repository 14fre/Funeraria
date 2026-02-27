<?php

namespace App\Livewire\Admin\Vehiculos;

use App\Models\Vehiculo;
use App\Services\VehiculoService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $tipoFilter = '';
    public $estadoFilter = '';
    public $perPage = 10;
    public $sortField = 'placa';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'tipoFilter' => ['except' => ''],
        'estadoFilter' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingTipoFilter(): void
    {
        $this->resetPage();
    }

    public function updatingEstadoFilter(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function delete(int $id): void
    {
        $service = app(VehiculoService::class);
        $vehiculo = $service->find($id);
        $this->authorize('delete', $vehiculo);
        $service->delete($vehiculo);
        session()->flash('success', 'Vehículo eliminado correctamente.');
    }

    public function render(VehiculoService $vehiculoService)
    {
        $this->authorize('viewAny', Vehiculo::class);

        $vehiculos = $vehiculoService->listPaginated(
            [
                'search' => $this->search,
                'tipo' => $this->tipoFilter,
                'estado' => $this->estadoFilter,
            ],
            $this->sortField,
            $this->sortDirection,
            $this->perPage
        );

        $stats = $vehiculoService->getStats();
        $tipos = [
            'carroza' => 'Carroza',
            'ambulancia' => 'Ambulancia',
            'van' => 'Van',
            'microbus' => 'Microbús',
        ];
        $estados = [
            'disponible' => 'Disponible',
            'en_servicio' => 'En servicio',
            'mantenimiento' => 'Mantenimiento',
            'fuera_servicio' => 'Fuera de servicio',
        ];

        return view('livewire.admin.vehiculos.index', [
            'vehiculos' => $vehiculos,
            'stats' => $stats,
            'tipos' => $tipos,
            'estados' => $estados,
        ]);
    }
}
