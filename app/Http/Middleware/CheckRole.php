<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Constants\Roles;

class CheckRole
{
    /**
     * Verifica que el usuario tenga el rol especificado
     * Uso: ->middleware('role:admin') o ->middleware('role:cliente')
     */
    public function handle($request, Closure $next, string $roleName)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Cargar la relación role si no está cargada
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }

        if (!$user->hasRole($roleName)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
