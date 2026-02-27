<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condolencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'obituario_id',
        'nombre',
        'email',
        'mensaje',
        'aprobado',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'aprobado' => 'boolean',
    ];

    // Relaciones
    public function obituario()
    {
        return $this->belongsTo(Obituario::class);
    }

    // Scopes
    public function scopeAprobadas($query)
    {
        return $query->where('aprobado', true);
    }

    public function scopePendientes($query)
    {
        return $query->where('aprobado', false);
    }
}

