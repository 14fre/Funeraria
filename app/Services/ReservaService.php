<?php

namespace App\Services;

use App\Contracts\Repositories\ReservaRepositoryInterface;
use App\Models\Reserva;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReservaService
{
    public function __construct(
        protected ReservaRepositoryInterface $repository
    ) {}

    public function listPaginated(array $filters = [], string $sortField = 'fecha_inicio', string $sortDirection = 'desc', int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginateList($filters, $sortField, $sortDirection, $perPage);
    }

    public function getStats(): array
    {
        return $this->repository->getStats();
    }

    public function find(int $id): Reserva
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): Reserva
    {
        return $this->repository->create($data);
    }

    public function update(Reserva $reserva, array $data): Reserva
    {
        return $this->repository->update($reserva, $data);
    }

    public function delete(Reserva $reserva): bool
    {
        return $this->repository->delete($reserva);
    }
}
