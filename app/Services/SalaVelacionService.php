<?php

namespace App\Services;

use App\Contracts\Repositories\SalaVelacionRepositoryInterface;
use App\Models\SalaVelacion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SalaVelacionService
{
    public function __construct(
        protected SalaVelacionRepositoryInterface $repository
    ) {}

    public function listPaginated(array $filters = [], string $sortField = 'nombre', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginateList($filters, $sortField, $sortDirection, $perPage);
    }

    public function getStats(): array
    {
        return $this->repository->getStats();
    }

    public function find(int $id): SalaVelacion
    {
        return $this->repository->findOrFail($id);
    }

    public function getDisponibles(): Collection
    {
        return $this->repository->getDisponibles();
    }

    public function create(array $data): SalaVelacion
    {
        return $this->repository->create($data);
    }

    public function update(SalaVelacion $sala, array $data): SalaVelacion
    {
        return $this->repository->update($sala, $data);
    }

    public function delete(SalaVelacion $sala): bool
    {
        return $this->repository->delete($sala);
    }
}
