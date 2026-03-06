<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'two_factor_via_email',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relaciones adicionales
    public function afiliado()
    {
        return $this->hasOne(Afiliado::class);
    }

    public function afiliadosAsesorados()
    {
        return $this->hasMany(Afiliado::class, 'asesor_id');
    }

    public function serviciosCoordinados()
    {
        return $this->hasMany(ServicioFunerario::class, 'coordinador_id');
    }

    public function vehiculosAsignados()
    {
        return $this->hasMany(Vehiculo::class, 'conductor_id');
    }

    public function pagosProcesados()
    {
        return $this->hasMany(Pago::class, 'procesado_por');
    }

    public function pqr()
    {
        return $this->hasMany(PQR::class);
    }

    public function pqrRespondidas()
    {
        return $this->hasMany(PQR::class, 'respondido_por');
    }

    public function logs()
    {
        return $this->hasMany(LogSistema::class);
    }

    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function hasRole(string $roleName): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->nombre === $roleName;
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(\App\Constants\Roles::ADMIN);
    }

    /**
     * Verificar si el usuario es cliente
     */
    public function isCliente(): bool
    {
        return $this->hasRole(\App\Constants\Roles::CLIENTE);
    }

    /**
     * Obtener la ruta del dashboard según el rol
     */
    public function getDashboardRoute(): string
    {
        if (!$this->role) {
            return '/dashboard';
        }

        return \App\Constants\Roles::getDashboardRoute($this->role->nombre);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_via_email' => 'boolean',
        ];
    }

    /**
     * Determina si la verificación en dos pasos está activa (TOTP o por correo).
     */
    public function hasEnabledTwoFactorAuthentication()
    {
        if (! empty($this->two_factor_via_email)) {
            return ! is_null($this->two_factor_confirmed_at);
        }
        if (\Laravel\Fortify\Fortify::confirmsTwoFactorAuthentication()) {
            return ! is_null($this->two_factor_secret) && ! is_null($this->two_factor_confirmed_at);
        }
        return ! is_null($this->two_factor_secret);
    }
}
