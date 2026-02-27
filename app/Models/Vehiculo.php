<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiculo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tipo',
        'placa',
        'marca',
        'modelo',
        'ano',
        'capacidad',
        'kilometraje',
        'estado',
        'conductor_id',
        'observaciones',
    ];

    // Relaciones
    public function conductor()
    {
        return $this->belongsTo(User::class, 'conductor_id');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'recurso_id')
            ->where('tipo_recurso', 'vehiculo');
    }

    public function mantenimientos()
    {
        return $this->hasMany(MantenimientoVehiculo::class);
    }

    // Scopes
    public function scopeDisponibles($query)
    {
        return $query->where('estado', 'disponible');
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}

