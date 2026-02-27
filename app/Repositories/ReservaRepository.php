<?php

namespace App\Repositories;

use App\Contracts\Repositories\ReservaRepositoryInterface;
use App\Models\Reserva;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReservaRepository implements ReservaRepositoryInterface
{
    public function __construct(
        protected Reserva $model
    ) {}

    public function find(int $id): ?Reserva
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): Reserva
    {
        return $this->model->newQuery()->with(['servicioFunerario'])->findOrFail($id);
    }

    public function paginateList(array $filters = [], string $sortField = 'fecha_inicio', string $sortDirection = 'desc', int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with(['servicioFunerario']);

        if (!empty($filters['tipo_recurso'])) {
            $query->where('tipo_recurso', $filters['tipo_recurso']);
        }

        if (isset($filters['estado']) && $filters['estado'] !== '') {
            $query->where('estado', $filters['estado']);
        }

        if (!empty($filters['fecha_desde'])) {
            $query->where('fecha_fin', '>=', $filters['fecha_desde']);
        }

        if (!empty($filters['fecha_hasta'])) {
            $query->where('fecha_inicio', '<=', $filters['fecha_hasta']);
        }

        return $query->orderBy($sortField, $sortDirection)->paginate($perPage);
    }

    public function create(array $data): Reserva
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(Reserva $reserva, array $data): Reserva
    {
        $reserva->update($data);
        return $reserva->fresh();
    }

    public function delete(Reserva $reserva): bool
    {
        return $reserva->delete();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->newQuery()->count(),
            'activas' => $this->model->newQuery()->activas()->count(),
            'reservada' => $this->model->newQuery()->where('estado', 'reservada')->count(),
            'confirmada' => $this->model->newQuery()->where('estado', 'confirmada')->count(),
            'completada' => $this->model->newQuery()->where('estado', 'completada')->count(),
        ];
    }
}
