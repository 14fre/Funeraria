<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PQR extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pqr';

    protected $fillable = [
        'user_id',
        'afiliado_id',
        'tipo',
        'asunto',
        'descripcion',
        'estado',
        'respuesta',
        'respondido_por',
        'fecha_respuesta',
        'observaciones',
    ];

    protected $casts = [
        'fecha_respuesta' => 'datetime',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    public function respondidoPor()
    {
        return $this->belongsTo(User::class, 'respondido_por');
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}

