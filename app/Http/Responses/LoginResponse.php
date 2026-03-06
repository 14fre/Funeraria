<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Redirige al dashboard según el rol del usuario (admin → /admin/dashboard, cliente → /cliente/dashboard).
     */
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user && method_exists($user, 'getDashboardRoute')) {
            if (! $user->relationLoaded('role')) {
                $user->load('role');
            }
            $url = $user->getDashboardRoute();
            return $request->wantsJson()
                ? response()->json(['two_factor' => false, 'redirect' => $url])
                : redirect()->intended($url);
        }

        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->intended(config('fortify.home', '/dashboard'));
    }
}
