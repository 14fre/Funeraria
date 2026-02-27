<?php

namespace App\Contracts\Repositories;

use App\Models\Vehiculo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface VehiculoRepositoryInterface
{
    public function find(int $id): ?Vehiculo;

    public function findOrFail(int $id): Vehiculo;

    public function all(): Collection;

    public function getDisponibles(): Collection;

    public function paginateList(array $filters = [], string $sortField = 'placa', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): Vehiculo;

    public function update(Vehiculo $vehiculo, array $data): Vehiculo;

    public function delete(Vehiculo $vehiculo): bool;

    public function getStats(): array;
}
