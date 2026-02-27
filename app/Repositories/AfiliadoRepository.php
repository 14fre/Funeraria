<?php

namespace App\Repositories;

use App\Contracts\Repositories\AfiliadoRepositoryInterface;
use App\Models\Afiliado;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AfiliadoRepository implements AfiliadoRepositoryInterface
{
    public function __construct(
        protected Afiliado $model
    ) {}

    public function find(int $id): ?Afiliado
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Afiliado
    {
        return $this->model->newQuery()->with(['user', 'planExequial', 'asesor'])->findOrFail($id);
    }

    public function getByUser(int $userId): ?Afiliado
    {
        return $this->model->newQuery()->where('user_id', $userId)->first();
    }

    public function paginateList(array $filters = [], string $sortField = 'numero_afiliacion', string $sortDirection = 'asc', int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with(['user', 'planExequial', 'asesor']);

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('numero_afiliacion', 'like', "%{$term}%")
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%"));
            });
        }

        if (!empty($filters['estado'])) {
            $query->where('estado', $filters['estado']);
        }

        if (!empty($filters['plan_id'])) {
            $query->where('plan_exequial_id', $filters['plan_id']);
        }

        return $query->orderBy($sortField, $sortDirection)->paginate($perPage);
    }

    public function create(array $data): Afiliado
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(Afiliado $afiliado, array $data): Afiliado
    {
        $afiliado->update($data);
        return $afiliado->fresh();
    }

    public function delete(Afiliado $afiliado): bool
    {
        return $afiliado->delete();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->newQuery()->count(),
            'activos' => $this->model->newQuery()->where('estado', 'activo')->count(),
            'suspendidos' => $this->model->newQuery()->where('estado', 'suspendido')->count(),
            'cancelados' => $this->model->newQuery()->where('estado', 'cancelado')->count(),
            'mora' => $this->model->newQuery()->where('estado', 'mora')->count(),
        ];
    }

    public function nextNumeroAfiliacion(): string
    {
        $prefix = 'AF-' . now()->format('Ym') . '-';
        $count = $this->model->newQuery()
            ->where('numero_afiliacion', 'like', $prefix . '%')
            ->count();

        return $prefix . str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);
    }
}
