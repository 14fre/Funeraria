<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'afiliado_id',
        'plan_exequial_id',
        'monto',
        'metodo_pago',
        'estado',
        'referencia',
        'numero_recibo',
        'fecha_pago',
        'periodo_desde',
        'periodo_hasta',
        'procesado_por',
        'observaciones',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'date',
        'periodo_desde' => 'date',
        'periodo_hasta' => 'date',
    ];

    // Relaciones
    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    public function planExequial()
    {
        return $this->belongsTo(PlanExequial::class, 'plan_exequial_id');
    }

    public function procesadoPor()
    {
        return $this->belongsTo(User::class, 'procesado_por');
    }

    // Scopes
    public function scopeAprobados($query)
    {
        return $query->where('estado', 'aprobado');
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopePorPeriodo($query, $desde, $hasta)
    {
        return $query->whereBetween('fecha_pago', [$desde, $hasta]);
    }
}

