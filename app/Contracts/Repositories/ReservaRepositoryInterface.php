<?php

namespace App\Contracts\Repositories;

use App\Models\Reserva;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ReservaRepositoryInterface
{
    public function find(int $id): ?Reserva;

    public function findOrFail(int $id): Reserva;

    public function paginateList(array $filters = [], string $sortField = 'fecha_inicio', string $sortDirection = 'desc', int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): Reserva;

    public function update(Reserva $reserva, array $data): Reserva;

    public function delete(Reserva $reserva): bool;

    public function getStats(): array;
}
