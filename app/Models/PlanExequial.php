<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanExequial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'planes_exequiales';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'max_beneficiarios',
        'precio_mensual',
        'precio_anual',
        'servicios_incluidos',
        'activo',
    ];

    protected $casts = [
        'servicios_incluidos' => 'array',
        'precio_mensual' => 'decimal:2',
        'precio_anual' => 'decimal:2',
        'activo' => 'boolean',
    ];

    // Relaciones
    public function afiliados()
    {
        return $this->hasMany(Afiliado::class, 'plan_exequial_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'plan_exequial_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}

