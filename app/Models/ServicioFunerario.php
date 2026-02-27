<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioFunerario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servicios_funerarios';

    protected $fillable = [
        'afiliado_id',
        'beneficiario_id',
        'tipo',
        'estado',
        'fecha_solicitud',
        'fecha_servicio',
        'hora_servicio',
        'coordinador_id',
        'observaciones',
        'detalles_servicio',
        'costo_adicional',
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_servicio' => 'date',
        'hora_servicio' => 'datetime',
        'detalles_servicio' => 'array',
        'costo_adicional' => 'decimal:2',
    ];

    // Relaciones
    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    public function beneficiario()
    {
        return $this->belongsTo(Beneficiario::class);
    }

    public function coordinador()
    {
        return $this->belongsTo(User::class, 'coordinador_id');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function obituario()
    {
        return $this->hasOne(Obituario::class);
    }

    // Scopes
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopePendientes($query)
    {
        return $query->whereIn('estado', ['solicitado', 'programado', 'en_proceso']);
    }
}

