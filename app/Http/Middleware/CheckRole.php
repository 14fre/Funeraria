<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Constants\Roles;

class CheckRole
{
    /**
     * Verifica que el usuario tenga el rol especificado.
     * Si no tiene el rol, redirige a su panel (cliente → /cliente/dashboard, admin → /admin/dashboard)
     * en lugar de mostrar 403.
     * Uso: ->middleware('role:admin') o ->middleware('role:cliente')
     */
    public function handle($request, Closure $next, string $roleName)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (! $user->relationLoaded('role')) {
            $user->load('role');
        }

        if ($user->hasRole($roleName)) {
            return $next($request);
        }

        // No tiene el rol: redirigir a su panel según su rol real (evita 403 por ruta equivocada)
        $dashboard = $user->getDashboardRoute();
        if ($dashboard === '/dashboard' || ! $user->role) {
            return redirect()->route('home')->with('info', 'No tienes asignado un panel de acceso. Contacta al administrador.');
        }
        return redirect($dashboard)->with('info', 'Has sido redirigido a tu panel.');
    }
}
