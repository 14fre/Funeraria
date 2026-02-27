<?php

namespace App\Contracts\Repositories;

use App\Models\ServicioFunerario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ServicioFunerarioRepositoryInterface
{
    public function find(int $id): ?ServicioFunerario;

    public function findOrFail(int $id): ServicioFunerario;

    public function getByAfiliado(int $afiliadoId): Collection;

    public function paginateList(array $filters = [], string $sortField = 'fecha_solicitud', string $sortDirection = 'desc', int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): ServicioFunerario;

    public function update(ServicioFunerario $servicio, array $data): ServicioFunerario;

    public function delete(ServicioFunerario $servicio): bool;

    public function getStats(): array;
}
