<?php

namespace App\Services;

use App\Contracts\Repositories\AfiliadoRepositoryInterface;
use App\Models\Afiliado;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class AfiliadoService
{
    public function __construct(
        protected AfiliadoRepositoryInterface $repository
    ) {}

    public function listPaginated(array $filters = [], string $sortField = 'numero_afiliacion', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginateList($filters, $sortField, $sortDirection, $perPage);
    }

    public function getStats(): array
    {
        return $this->repository->getStats();
    }

    public function find(int $id): Afiliado
    {
        return $this->repository->findOrFail($id);
    }

    public function getByUser(int $userId): ?Afiliado
    {
        return $this->repository->getByUser($userId);
    }

    public function create(array $data): Afiliado
    {
        if (empty($data['numero_afiliacion'])) {
            $data['numero_afiliacion'] = $this->repository->nextNumeroAfiliacion();
        }
        if (empty($data['fecha_afiliacion'])) {
            $data['fecha_afiliacion'] = now()->toDateString();
        }
        $userAlreadyAfiliado = $this->repository->getByUser((int) $data['user_id']);
        if ($userAlreadyAfiliado) {
            throw ValidationException::withMessages([
                'user_id' => ['Este usuario ya tiene una afiliación activa.'],
            ]);
        }
        return $this->repository->create($data);
    }

    public function update(Afiliado $afiliado, array $data): Afiliado
    {
        return $this->repository->update($afiliado, $data);
    }

    public function delete(Afiliado $afiliado): bool
    {
        if ($afiliado->beneficiarios()->count() > 0 || $afiliado->pagos()->count() > 0) {
            throw ValidationException::withMessages([
                'afiliado' => ['No se puede eliminar el afiliado: tiene beneficiarios o pagos asociados.'],
            ]);
        }
        return $this->repository->delete($afiliado);
    }
}
