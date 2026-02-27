<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'servicio_funerario_id',
        'tipo_recurso',
        'recurso_id',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'hora_inicio' => 'datetime',
        'hora_fin' => 'datetime',
    ];

    // Relaciones
    public function servicioFunerario()
    {
        return $this->belongsTo(ServicioFunerario::class);
    }

    public function sala()
    {
        return $this->belongsTo(SalaVelacion::class, 'recurso_id')
            ->where('tipo_recurso', 'sala');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'recurso_id')
            ->where('tipo_recurso', 'vehiculo');
    }

    /** Nombre del recurso (sala o vehículo) para mostrar en listados */
    public function getRecursoNombreAttribute(): string
    {
        if ($this->tipo_recurso === 'sala') {
            $sala = SalaVelacion::find($this->recurso_id);
            return $sala ? $sala->nombre : 'Sala #' . $this->recurso_id;
        }
        if ($this->tipo_recurso === 'vehiculo') {
            $v = Vehiculo::find($this->recurso_id);
            return $v ? ($v->placa ?? 'Veh. #' . $this->recurso_id) : 'Veh. #' . $this->recurso_id;
        }
        return 'Recurso #' . $this->recurso_id;
    }

    // Scopes
    public function scopeActivas($query)
    {
        return $query->whereIn('estado', ['reservada', 'confirmada']);
    }
}

