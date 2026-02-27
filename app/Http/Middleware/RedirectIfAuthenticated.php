<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Cargar la relación role si no está cargada
                if (!$user->relationLoaded('role')) {
                    $user->load('role');
                }

                // Redirigir según el rol del usuario
                if ($user->role) {
                    return redirect($user->getDashboardRoute());
                }

                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}

