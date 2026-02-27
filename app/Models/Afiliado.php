<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Afiliado extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'plan_exequial_id',
        'numero_afiliacion',
        'fecha_afiliacion',
        'estado',
        'asesor_id',
        'observaciones',
    ];

    protected $casts = [
        'fecha_afiliacion' => 'date',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function planExequial()
    {
        return $this->belongsTo(PlanExequial::class, 'plan_exequial_id');
    }

    public function asesor()
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function beneficiarios()
    {
        return $this->hasMany(Beneficiario::class);
    }

    public function servicios()
    {
        return $this->hasMany(ServicioFunerario::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function pqr()
    {
        return $this->hasMany(PQR::class);
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }
}

