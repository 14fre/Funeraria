<?php

namespace App\Contracts\Repositories;

use App\Models\Beneficiario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BeneficiarioRepositoryInterface
{
    public function find(int $id): ?Beneficiario;

    public function findOrFail(int $id): Beneficiario;

    public function getByAfiliado(int $afiliadoId): Collection;

    public function paginateList(array $filters = [], string $sortField = 'nombres', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): Beneficiario;

    public function update(Beneficiario $beneficiario, array $data): Beneficiario;

    public function delete(Beneficiario $beneficiario): bool;
}
