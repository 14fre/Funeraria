<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaVelacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'salas_velacion';

    protected $fillable = [
        'nombre',
        'descripcion',
        'capacidad',
        'ubicacion',
        'servicios_incluidos',
        'precio_hora',
        'estado',
    ];

    protected $casts = [
        'precio_hora' => 'decimal:2',
    ];

    // Relaciones
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'recurso_id')
            ->where('tipo_recurso', 'sala');
    }

    // Scopes
    public function scopeDisponibles($query)
    {
        return $query->where('estado', 'disponible');
    }
}

