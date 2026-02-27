<?php

namespace App\Contracts\Repositories;

use App\Models\Obituario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ObituarioRepositoryInterface
{
    public function find(int $id): ?Obituario;

    public function findOrFail(int $id): Obituario;

    public function all(): Collection;

    public function paginateList(array $filters = [], string $sortField = 'fecha_fallecimiento', string $sortDirection = 'desc', int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): Obituario;

    public function update(Obituario $obituario, array $data): Obituario;

    public function delete(Obituario $obituario): bool;

    public function getStats(): array;
}
