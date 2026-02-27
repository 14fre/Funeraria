<?php

namespace App\Repositories;

use App\Contracts\Repositories\SalaVelacionRepositoryInterface;
use App\Models\SalaVelacion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SalaVelacionRepository implements SalaVelacionRepositoryInterface
{
    public function __construct(
        protected SalaVelacion $model
    ) {}

    public function find(int $id): ?SalaVelacion
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): SalaVelacion
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->newQuery()->orderBy('nombre')->get();
    }

    public function getDisponibles(): Collection
    {
        return $this->model->newQuery()->disponibles()->orderBy('nombre')->get();
    }

    public function paginateList(array $filters = [], string $sortField = 'nombre', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('nombre', 'like', "%{$term}%")
                    ->orWhere('ubicacion', 'like', "%{$term}%");
            });
        }

        if (isset($filters['estado']) && $filters['estado'] !== '') {
            $query->where('estado', $filters['estado']);
        }

        return $query->orderBy($sortField, $sortDirection)->paginate($perPage);
    }

    public function create(array $data): SalaVelacion
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(SalaVelacion $sala, array $data): SalaVelacion
    {
        $sala->update($data);
        return $sala->fresh();
    }

    public function delete(SalaVelacion $sala): bool
    {
        return $sala->delete();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->newQuery()->count(),
            'disponible' => $this->model->newQuery()->disponibles()->count(),
            'ocupada' => $this->model->newQuery()->where('estado', 'ocupada')->count(),
            'mantenimiento' => $this->model->newQuery()->where('estado', 'mantenimiento')->count(),
        ];
    }
}
