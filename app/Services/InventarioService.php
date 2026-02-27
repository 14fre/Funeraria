<?php

namespace App\Services;

use App\Contracts\Repositories\InventarioRepositoryInterface;
use App\Models\Inventario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class InventarioService
{
    public function __construct(
        protected InventarioRepositoryInterface $repository
    ) {}

    public function listPaginated(array $filters = [], string $sortField = 'nombre', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginateList($filters, $sortField, $sortDirection, $perPage);
    }

    public function getStats(): array
    {
        return $this->repository->getStats();
    }

    public function find(int $id): Inventario
    {
        return $this->repository->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->repository->all();
    }

    public function create(array $data): Inventario
    {
        return $this->repository->create($data);
    }

    public function update(Inventario $item, array $data): Inventario
    {
        return $this->repository->update($item, $data);
    }

    public function delete(Inventario $item): bool
    {
        return $this->repository->delete($item);
    }
}
