<?php

namespace App\Livewire\Admin\Beneficiarios;

use App\Models\Beneficiario;
use App\Services\AfiliadoService;
use App\Services\BeneficiarioService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $afiliadoFilter = '';
    public $perPage = 10;
    public $sortField = 'nombres';
    public $sortDirection = 'asc';

    protected $queryString = ['search' => ['except' => ''], 'afiliadoFilter' => ['except' => '']];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingAfiliadoFilter() { $this->resetPage(); }

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
        $service = app(BeneficiarioService::class);
        $beneficiario = $service->find($id);
        $this->authorize('delete', $beneficiario);
        try {
            $service->delete($beneficiario);
            session()->flash('success', 'Beneficiario eliminado.');
        } catch (ValidationException $e) {
            session()->flash('error', $e->validator->errors()->first('beneficiario'));
        }
    }

    public function render(BeneficiarioService $beneficiarioService, AfiliadoService $afiliadoService)
    {
        $this->authorize('viewAny', Beneficiario::class);
        $beneficiarios = $beneficiarioService->listPaginated(
            ['search' => $this->search, 'afiliado_id' => $this->afiliadoFilter],
            $this->sortField,
            $this->sortDirection,
            $this->perPage
        );
        $afiliadosPaginator = $afiliadoService->listPaginated([], 'numero_afiliacion', 'asc', 500);
        return view('livewire.admin.beneficiarios.index', [
            'beneficiarios' => $beneficiarios,
            'afiliadosPaginator' => $afiliadosPaginator,
        ]);
    }
}
