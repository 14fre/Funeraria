<?php

namespace App\Repositories;

use App\Contracts\Repositories\BeneficiarioRepositoryInterface;
use App\Models\Beneficiario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BeneficiarioRepository implements BeneficiarioRepositoryInterface
{
    public function __construct(
        protected Beneficiario $model
    ) {}

    public function find(int $id): ?Beneficiario
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Beneficiario
    {
        return $this->model->newQuery()->with('afiliado.user')->findOrFail($id);
    }

    public function getByAfiliado(int $afiliadoId): Collection
    {
        return $this->model->newQuery()->where('afiliado_id', $afiliadoId)->orderBy('nombres')->get();
    }

    public function paginateList(array $filters = [], string $sortField = 'nombres', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with('afiliado.user');

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('nombres', 'like', "%{$term}%")
                    ->orWhere('apellidos', 'like', "%{$term}%")
                    ->orWhere('numero_documento', 'like', "%{$term}%");
            });
        }

        if (!empty($filters['afiliado_id'])) {
            $query->where('afiliado_id', $filters['afiliado_id']);
        }

        if (isset($filters['activo']) && $filters['activo'] !== '') {
            $query->where('activo', $filters['activo'] === '1');
        }

        return $query->orderBy($sortField, $sortDirection)->paginate($perPage);
    }

    public function create(array $data): Beneficiario
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(Beneficiario $beneficiario, array $data): Beneficiario
    {
        $beneficiario->update($data);
        return $beneficiario->fresh();
    }

    public function delete(Beneficiario $beneficiario): bool
    {
        return $beneficiario->delete();
    }
}
