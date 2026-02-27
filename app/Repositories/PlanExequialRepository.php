<?php

namespace App\Repositories;

use App\Contracts\Repositories\PlanExequialRepositoryInterface;
use App\Models\PlanExequial;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PlanExequialRepository implements PlanExequialRepositoryInterface
{
    public function __construct(
        protected PlanExequial $model
    ) {}

    public function find(int $id): ?PlanExequial
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): PlanExequial
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->newQuery()->orderBy('nombre')->get();
    }

    public function getActivos(): Collection
    {
        return $this->model->newQuery()->activos()->orderBy('nombre')->get();
    }

    public function paginateList(array $filters = [], string $sortField = 'nombre', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('nombre', 'like', "%{$term}%")
                    ->orWhere('descripcion', 'like', "%{$term}%");
            });
        }

        if (!empty($filters['tipo'])) {
            $query->where('tipo', $filters['tipo']);
        }

        if (isset($filters['activo']) && $filters['activo'] !== '') {
            $query->where('activo', $filters['activo'] === 'activo');
        }

        return $query->orderBy($sortField, $sortDirection)->paginate($perPage);
    }

    public function create(array $data): PlanExequial
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(PlanExequial $plan, array $data): PlanExequial
    {
        $plan->update($data);
        return $plan->fresh();
    }

    public function delete(PlanExequial $plan): bool
    {
        return $plan->delete();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->newQuery()->count(),
            'activos' => $this->model->newQuery()->where('activo', true)->count(),
            'inactivos' => $this->model->newQuery()->where('activo', false)->count(),
        ];
    }
}
