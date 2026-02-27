<?php

namespace App\Services;

use App\Contracts\Repositories\VehiculoRepositoryInterface;
use App\Models\Vehiculo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class VehiculoService
{
    public function __construct(
        protected VehiculoRepositoryInterface $repository
    ) {}

    public function listPaginated(array $filters = [], string $sortField = 'placa', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginateList($filters, $sortField, $sortDirection, $perPage);
    }

    public function getStats(): array
    {
        return $this->repository->getStats();
    }

    public function find(int $id): Vehiculo
    {
        return $this->repository->findOrFail($id);
    }

    public function getDisponibles(): Collection
    {
        return $this->repository->getDisponibles();
    }

    public function create(array $data): Vehiculo
    {
        return $this->repository->create($data);
    }

    public function update(Vehiculo $vehiculo, array $data): Vehiculo
    {
        return $this->repository->update($vehiculo, $data);
    }

    public function delete(Vehiculo $vehiculo): bool
    {
        return $this->repository->delete($vehiculo);
    }
}
