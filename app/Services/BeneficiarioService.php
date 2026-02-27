<?php

namespace App\Services;

use App\Contracts\Repositories\BeneficiarioRepositoryInterface;
use App\Models\Afiliado;
use App\Models\Beneficiario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class BeneficiarioService
{
    public function __construct(
        protected BeneficiarioRepositoryInterface $repository
    ) {}

    public function listPaginated(array $filters = [], string $sortField = 'nombres', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginateList($filters, $sortField, $sortDirection, $perPage);
    }

    public function find(int $id): Beneficiario
    {
        return $this->repository->findOrFail($id);
    }

    public function getByAfiliado(int $afiliadoId): Collection
    {
        return $this->repository->getByAfiliado($afiliadoId);
    }

    public function create(array $data): Beneficiario
    {
        $this->assertAfiliadoCanAddBeneficiario((int) $data['afiliado_id']);
        return $this->repository->create($data);
    }

    public function update(Beneficiario $beneficiario, array $data): Beneficiario
    {
        return $this->repository->update($beneficiario, $data);
    }

    public function delete(Beneficiario $beneficiario): bool
    {
        if ($beneficiario->servicios()->count() > 0) {
            throw ValidationException::withMessages([
                'beneficiario' => ['No se puede eliminar: tiene servicios funerarios asociados.'],
            ]);
        }
        return $this->repository->delete($beneficiario);
    }

    protected function assertAfiliadoCanAddBeneficiario(int $afiliadoId): void
    {
        $afiliado = Afiliado::with('planExequial')->findOrFail($afiliadoId);
        $max = $afiliado->planExequial->max_beneficiarios ?? 999;
        $current = $this->repository->getByAfiliado($afiliadoId)->count();
        if ($current >= $max) {
            throw ValidationException::withMessages([
                'afiliado_id' => ["El plan permite máximo {$max} beneficiarios. Ya tiene {$current}."],
            ]);
        }
    }
}
