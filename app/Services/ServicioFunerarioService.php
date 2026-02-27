<?php

namespace App\Services;

use App\Contracts\Repositories\ServicioFunerarioRepositoryInterface;
use App\Models\ServicioFunerario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ServicioFunerarioService
{
    public function __construct(
        protected ServicioFunerarioRepositoryInterface $repository
    ) {}

    public function listPaginated(array $filters = [], string $sortField = 'fecha_solicitud', string $sortDirection = 'desc', int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginateList($filters, $sortField, $sortDirection, $perPage);
    }

    public function getStats(): array
    {
        return $this->repository->getStats();
    }

    public function find(int $id): ServicioFunerario
    {
        return $this->repository->findOrFail($id);
    }

    public function getByAfiliado(int $afiliadoId): Collection
    {
        return $this->repository->getByAfiliado($afiliadoId);
    }

    public function create(array $data): ServicioFunerario
    {
        if (empty($data['fecha_solicitud'])) {
            $data['fecha_solicitud'] = now()->toDateString();
        }
        return $this->repository->create($data);
    }

    public function update(ServicioFunerario $servicio, array $data): ServicioFunerario
    {
        return $this->repository->update($servicio, $data);
    }

    public function delete(ServicioFunerario $servicio): bool
    {
        return $this->repository->delete($servicio);
    }
}
