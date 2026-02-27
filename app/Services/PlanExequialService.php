<?php

namespace App\Services;

use App\Contracts\Repositories\PlanExequialRepositoryInterface;
use App\Models\PlanExequial;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class PlanExequialService
{
    public function __construct(
        protected PlanExequialRepositoryInterface $repository
    ) {}

    public function listPaginated(array $filters = [], string $sortField = 'nombre', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginateList($filters, $sortField, $sortDirection, $perPage);
    }

    public function getStats(): array
    {
        return $this->repository->getStats();
    }

    public function find(int $id): PlanExequial
    {
        return $this->repository->findOrFail($id);
    }

    public function getActivos(): Collection
    {
        return $this->repository->getActivos();
    }

    public function create(array $data): PlanExequial
    {
        $plan = $this->repository->create($data);
        // Event::dispatch(new PlanExequialCreado($plan)); // Fase eventos
        return $plan;
    }

    public function update(PlanExequial $plan, array $data): PlanExequial
    {
        $plan = $this->repository->update($plan, $data);
        // Event::dispatch(new PlanExequialActualizado($plan));
        return $plan;
    }

    public function toggleActivo(PlanExequial $plan): PlanExequial
    {
        $plan->activo = !$plan->activo;
        return $this->repository->update($plan, ['activo' => $plan->activo]);
    }

    /**
     * Elimina el plan si no tiene afiliados asociados.
     *
     * @throws ValidationException
     */
    public function delete(PlanExequial $plan): bool
    {
        if ($plan->afiliados()->count() > 0) {
            throw ValidationException::withMessages([
                'plan' => ['No se puede eliminar el plan porque tiene afiliados asociados.'],
            ]);
        }
        return $this->repository->delete($plan);
    }
}
