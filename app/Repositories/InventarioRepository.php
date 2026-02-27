<?php

namespace App\Repositories;

use App\Contracts\Repositories\InventarioRepositoryInterface;
use App\Models\Inventario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class InventarioRepository implements InventarioRepositoryInterface
{
    public function __construct(
        protected Inventario $model
    ) {}

    public function find(int $id): ?Inventario
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): Inventario
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->newQuery()->orderBy('nombre')->get();
    }

    public function paginateList(array $filters = [], string $sortField = 'nombre', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('nombre', 'like', "%{$term}%")
                    ->orWhere('marca', 'like', "%{$term}%")
                    ->orWhere('proveedor', 'like', "%{$term}%");
            });
        }

        if (!empty($filters['tipo'])) {
            $query->where('tipo', $filters['tipo']);
        }

        if (isset($filters['estado']) && $filters['estado'] !== '') {
            $query->where('estado', $filters['estado']);
        }

        if (!empty($filters['bajo_stock'])) {
            $query->bajoStock();
        }

        return $query->orderBy($sortField, $sortDirection)->paginate($perPage);
    }

    public function create(array $data): Inventario
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(Inventario $item, array $data): Inventario
    {
        $item->update($data);
        return $item->fresh();
    }

    public function delete(Inventario $item): bool
    {
        return $item->delete();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->newQuery()->count(),
            'disponible' => $this->model->newQuery()->disponibles()->count(),
            'agotado' => $this->model->newQuery()->where('estado', 'agotado')->count(),
            'bajo_stock' => $this->model->newQuery()->bajoStock()->count(),
        ];
    }
}
