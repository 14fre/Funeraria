<?php

namespace App\Services;

use App\Contracts\Repositories\ObituarioRepositoryInterface;
use App\Models\Obituario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ObituarioService
{
    public function __construct(
        protected ObituarioRepositoryInterface $repository
    ) {}

    public function listPaginated(array $filters = [], string $sortField = 'fecha_fallecimiento', string $sortDirection = 'desc', int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginateList($filters, $sortField, $sortDirection, $perPage);
    }

    public function getStats(): array
    {
        return $this->repository->getStats();
    }

    public function find(int $id): Obituario
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): Obituario
    {
        return $this->repository->create($data);
    }

    public function update(Obituario $obituario, array $data): Obituario
    {
        return $this->repository->update($obituario, $data);
    }

    public function delete(Obituario $obituario): bool
    {
        return $this->repository->delete($obituario);
    }
}
