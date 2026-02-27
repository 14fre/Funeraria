<?php

namespace App\Repositories;

use App\Contracts\Repositories\ObituarioRepositoryInterface;
use App\Models\Obituario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ObituarioRepository implements ObituarioRepositoryInterface
{
    public function __construct(
        protected Obituario $model
    ) {}

    public function find(int $id): ?Obituario
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): Obituario
    {
        return $this->model->newQuery()->with('servicioFunerario')->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->newQuery()->orderByDesc('fecha_fallecimiento')->get();
    }

    public function paginateList(array $filters = [], string $sortField = 'fecha_fallecimiento', string $sortDirection = 'desc', int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with('servicioFunerario');

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('nombre_completo', 'like', "%{$term}%")
                    ->orWhere('numero_documento', 'like', "%{$term}%");
            });
        }

        if (isset($filters['publicado']) && $filters['publicado'] !== '') {
            $query->where('publicado', $filters['publicado'] === '1');
        }

        return $query->orderBy($sortField, $sortDirection)->paginate($perPage);
    }

    public function create(array $data): Obituario
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(Obituario $obituario, array $data): Obituario
    {
        $obituario->update($data);
        return $obituario->fresh(['servicioFunerario']);
    }

    public function delete(Obituario $obituario): bool
    {
        return $obituario->delete();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->newQuery()->count(),
            'publicados' => $this->model->newQuery()->publicados()->count(),
            'no_publicados' => $this->model->newQuery()->where('publicado', false)->count(),
        ];
    }
}
