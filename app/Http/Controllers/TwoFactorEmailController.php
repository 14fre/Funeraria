<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwoFactorEmailController extends Controller
{
    public function enable(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'current_password'],
        ], [
            'password.current_password' => 'La contraseña no es correcta.',
        ]);

        $user = $request->user();
        $user->forceFill([
            'two_factor_secret' => encrypt(\App\Actions\Fortify\TwoFactorAuthenticationProviderEmailAware::EMAIL_SECRET),
            'two_factor_confirmed_at' => now(),
            'two_factor_via_email' => true,
        ])->save();

        return back()->with('status', 'two-factor-email-enabled');
    }

    public function disable(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'current_password'],
        ], [
            'password.current_password' => 'La contraseña no es correcta.',
        ]);

        $user = $request->user();
        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_confirmed_at' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_via_email' => false,
        ])->save();

        return back()->with('status', 'two-factor-email-disabled');
    }
}
