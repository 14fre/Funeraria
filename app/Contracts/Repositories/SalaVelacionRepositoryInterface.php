<?php

namespace App\Contracts\Repositories;

use App\Models\SalaVelacion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SalaVelacionRepositoryInterface
{
    public function find(int $id): ?SalaVelacion;

    public function findOrFail(int $id): SalaVelacion;

    public function all(): Collection;

    public function getDisponibles(): Collection;

    public function paginateList(array $filters = [], string $sortField = 'nombre', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): SalaVelacion;

    public function update(SalaVelacion $sala, array $data): SalaVelacion;

    public function delete(SalaVelacion $sala): bool;

    public function getStats(): array;
}
