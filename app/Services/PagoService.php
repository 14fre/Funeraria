<?php

namespace App\Services;

use App\Models\Afiliado;
use App\Models\Pago;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PagoService
{
    public function listPaginated(array $filters = [], string $sortField = 'fecha_pago', string $sortDirection = 'desc', int $perPage = 15): LengthAwarePaginator
    {
        $query = Pago::query()->with(['afiliado.user', 'planExequial', 'procesadoPor']);

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('referencia', 'like', "%{$term}%")
                    ->orWhere('numero_recibo', 'like', "%{$term}%")
                    ->orWhereHas('afiliado', function ($q) use ($term) {
                        $q->where('numero_afiliacion', 'like', "%{$term}%")
                            ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%"));
                    });
            });
        }

        if (!empty($filters['estado'])) {
            $query->where('estado', $filters['estado']);
        }

        if (!empty($filters['fecha_desde'])) {
            $query->where(function ($q) use ($filters) {
                $q->whereNotNull('fecha_pago')->where('fecha_pago', '>=', $filters['fecha_desde']);
            });
        }

        if (!empty($filters['fecha_hasta'])) {
            $query->where(function ($q) use ($filters) {
                $q->whereNotNull('fecha_pago')->where('fecha_pago', '<=', $filters['fecha_hasta']);
            });
        }

        if (!empty($filters['afiliado_id'])) {
            $query->where('afiliado_id', $filters['afiliado_id']);
        }

        return $query->orderBy($sortField, $sortDirection)
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function getStats(): array
    {
        return [
            'total' => Pago::count(),
            'pendientes' => Pago::where('estado', 'pendiente')->count(),
            'aprobados' => Pago::where('estado', 'aprobado')->count(),
            'rechazados' => Pago::where('estado', 'rechazado')->count(),
            'anulados' => Pago::where('estado', 'anulado')->count(),
        ];
    }

    public function find(int $id): Pago
    {
        return Pago::with(['afiliado.user', 'planExequial', 'procesadoPor'])->findOrFail($id);
    }

    /**
     * Registrar un pago (alta manual por admin).
     */
    public function create(array $data): Pago
    {
        $afiliado = Afiliado::with('planExequial')->findOrFail($data['afiliado_id']);
        $planId = $data['plan_exequial_id'] ?? $afiliado->plan_exequial_id;
        if (!$planId) {
            throw new \InvalidArgumentException('El afiliado no tiene plan asignado o debe indicar un plan.');
        }

        $pago = Pago::create([
            'afiliado_id' => $afiliado->id,
            'plan_exequial_id' => $planId,
            'monto' => $data['monto'],
            'metodo_pago' => $data['metodo_pago'],
            'estado' => $data['estado'] ?? 'aprobado',
            'referencia' => $data['referencia'] ?? null,
            'numero_recibo' => $data['numero_recibo'] ?? null,
            'fecha_pago' => $data['fecha_pago'] ?? now()->toDateString(),
            'periodo_desde' => $data['periodo_desde'] ?? null,
            'periodo_hasta' => $data['periodo_hasta'] ?? null,
            'procesado_por' => auth()->id(),
            'observaciones' => $data['observaciones'] ?? null,
        ]);

        return $pago->load(['afiliado.user', 'planExequial', 'procesadoPor']);
    }

    public function updateEstado(Pago $pago, string $estado): Pago
    {
        if (!in_array($estado, ['pendiente', 'aprobado', 'rechazado', 'anulado'], true)) {
            throw new \InvalidArgumentException('Estado no válido.');
        }
        $pago->update(['estado' => $estado]);
        return $pago->fresh();
    }
}
