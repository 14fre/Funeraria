<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudAfiliacion extends Model
{
    protected $table = 'solicitudes_afiliacion';

    protected $fillable = [
        'user_id',
        'plan_exequial_id',
        'estado',
        'mensaje',
        'observaciones',
        'responded_at',
        'responded_by',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function planExequial(): BelongsTo
    {
        return $this->belongsTo(PlanExequial::class, 'plan_exequial_id');
    }

    public function respondedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }
}
