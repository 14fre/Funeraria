<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Constants\Roles;

class RoleRedirect
{
    /**
     * Redirige a los usuarios autenticados a su dashboard según su rol
     * Este middleware se usa en rutas públicas para evitar que usuarios
     * autenticados accedan a páginas como login o register
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Cargar la relación role si no está cargada
            if (!$user->relationLoaded('role')) {
                $user->load('role');
            }

            if ($user->role) {
                $dashboardRoute = Roles::getDashboardRoute($user->role->nombre);
                return redirect($dashboardRoute);
            }
        }

        return $next($request);
    }
}
