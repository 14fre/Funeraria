<?php

namespace App\Contracts\Repositories;

use App\Models\PlanExequial;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PlanExequialRepositoryInterface
{
    public function find(int $id): ?PlanExequial;

    public function findOrFail(int $id): PlanExequial;

    public function all(): Collection;

    public function getActivos(): Collection;

    public function paginateList(array $filters = [], string $sortField = 'nombre', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): PlanExequial;

    public function update(PlanExequial $plan, array $data): PlanExequial;

    public function delete(PlanExequial $plan): bool;

    public function getStats(): array;
}
