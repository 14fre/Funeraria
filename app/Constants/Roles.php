<?php

namespace App\Constants;

class Roles
{
    public const ADMIN = 'admin';
    public const CLIENTE = 'cliente';

    /**
     * Obtener el ID del rol por nombre
     */
    public static function getId(string $roleName): ?int
    {
        return match ($roleName) {
            self::ADMIN => 1,
            self::CLIENTE => 2,
            default => null,
        };
    }

    /**
     * Obtener el nombre del rol por ID
     */
    public static function getName(int $roleId): ?string
    {
        return match ($roleId) {
            1 => self::ADMIN,
            2 => self::CLIENTE,
            default => null,
        };
    }

    /**
     * Obtener todas las rutas de dashboard por rol
     */
    public static function getDashboardRoute(string $roleName): string
    {
        return match ($roleName) {
            self::ADMIN => '/admin/dashboard',
            self::CLIENTE => '/cliente/dashboard',
            default => '/dashboard',
        };
    }
}

