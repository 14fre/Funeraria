<?php

namespace App\Repositories;

use App\Contracts\Repositories\ServicioFunerarioRepositoryInterface;
use App\Models\ServicioFunerario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ServicioFunerarioRepository implements ServicioFunerarioRepositoryInterface
{
    public function __construct(
        protected ServicioFunerario $model
    ) {}

    public function find(int $id): ?ServicioFunerario
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): ServicioFunerario
    {
        return $this->model->newQuery()->with(['afiliado.user', 'beneficiario', 'coordinador'])->findOrFail($id);
    }

    public function getByAfiliado(int $afiliadoId): Collection
    {
        return $this->model->newQuery()->where('afiliado_id', $afiliadoId)->with('beneficiario')->orderByDesc('fecha_solicitud')->get();
    }

    public function paginateList(array $filters = [], string $sortField = 'fecha_solicitud', string $sortDirection = 'desc', int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with(['afiliado.user', 'beneficiario', 'coordinador']);

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->whereHas('afiliado', fn ($q) => $q->where('numero_afiliacion', 'like', "%{$term}%")->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$term}%")));
        }
        if (!empty($filters['estado'])) {
            $query->where('estado', $filters['estado']);
        }
        if (!empty($filters['tipo'])) {
            $query->where('tipo', $filters['tipo']);
        }
        if (!empty($filters['afiliado_id'])) {
            $query->where('afiliado_id', $filters['afiliado_id']);
        }

        return $query->orderBy($sortField, $sortDirection)->paginate($perPage);
    }

    public function create(array $data): ServicioFunerario
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(ServicioFunerario $servicio, array $data): ServicioFunerario
    {
        $servicio->update($data);
        return $servicio->fresh();
    }

    public function delete(ServicioFunerario $servicio): bool
    {
        return $servicio->delete();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->newQuery()->count(),
            'solicitado' => $this->model->newQuery()->where('estado', 'solicitado')->count(),
            'programado' => $this->model->newQuery()->where('estado', 'programado')->count(),
            'en_proceso' => $this->model->newQuery()->where('estado', 'en_proceso')->count(),
            'completado' => $this->model->newQuery()->where('estado', 'completado')->count(),
            'cancelado' => $this->model->newQuery()->where('estado', 'cancelado')->count(),
        ];
    }
}
