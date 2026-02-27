<?php

namespace App\Repositories;

use App\Contracts\Repositories\VehiculoRepositoryInterface;
use App\Models\Vehiculo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class VehiculoRepository implements VehiculoRepositoryInterface
{
    public function __construct(
        protected Vehiculo $model
    ) {}

    public function find(int $id): ?Vehiculo
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): Vehiculo
    {
        return $this->model->newQuery()->with('conductor')->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->newQuery()->orderBy('placa')->get();
    }

    public function getDisponibles(): Collection
    {
        return $this->model->newQuery()->disponibles()->orderBy('placa')->get();
    }

    public function paginateList(array $filters = [], string $sortField = 'placa', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with('conductor');

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('placa', 'like', "%{$term}%")
                    ->orWhere('marca', 'like', "%{$term}%")
                    ->orWhere('modelo', 'like', "%{$term}%");
            });
        }

        if (!empty($filters['tipo'])) {
            $query->where('tipo', $filters['tipo']);
        }

        if (isset($filters['estado']) && $filters['estado'] !== '') {
            $query->where('estado', $filters['estado']);
        }

        return $query->orderBy($sortField, $sortDirection)->paginate($perPage);
    }

    public function create(array $data): Vehiculo
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(Vehiculo $vehiculo, array $data): Vehiculo
    {
        $vehiculo->update($data);
        return $vehiculo->fresh(['conductor']);
    }

    public function delete(Vehiculo $vehiculo): bool
    {
        return $vehiculo->delete();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->newQuery()->count(),
            'disponible' => $this->model->newQuery()->disponibles()->count(),
            'en_servicio' => $this->model->newQuery()->where('estado', 'en_servicio')->count(),
            'mantenimiento' => $this->model->newQuery()->where('estado', 'mantenimiento')->count(),
        ];
    }
}
