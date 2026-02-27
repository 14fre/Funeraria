<?php

namespace App\Contracts\Repositories;

use App\Models\Afiliado;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AfiliadoRepositoryInterface
{
    public function find(int $id): ?Afiliado;

    public function findOrFail(int $id): Afiliado;

    public function getByUser(int $userId): ?Afiliado;

    public function paginateList(array $filters = [], string $sortField = 'numero_afiliacion', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): Afiliado;

    public function update(Afiliado $afiliado, array $data): Afiliado;

    public function delete(Afiliado $afiliado): bool;

    public function getStats(): array;

    public function nextNumeroAfiliacion(): string;
}
