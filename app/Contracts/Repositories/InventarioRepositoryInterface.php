<?php

namespace App\Contracts\Repositories;

use App\Models\Inventario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface InventarioRepositoryInterface
{
    public function find(int $id): ?Inventario;

    public function findOrFail(int $id): Inventario;

    public function all(): Collection;

    public function paginateList(array $filters = [], string $sortField = 'nombre', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): Inventario;

    public function update(Inventario $item, array $data): Inventario;

    public function delete(Inventario $item): bool;

    public function getStats(): array;
}
