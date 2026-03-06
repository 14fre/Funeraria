<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\LoginRateLimiter;
use Laravel\Fortify\TwoFactorAuthenticatable;

class RedirectIfTwoFactorAuthenticatableWithEmail extends RedirectIfTwoFactorAuthenticatable
{
    public function __construct(StatefulGuard $guard, LoginRateLimiter $limiter)
    {
        parent::__construct($guard, $limiter);
    }

    public function handle($request, $next)
    {
        $user = $this->validateCredentials($request);

        $usesTwoFactor = in_array(TwoFactorAuthenticatable::class, class_uses_recursive($user));
        $hasApp2FA = optional($user)->two_factor_secret && ! is_null(optional($user)->two_factor_confirmed_at);
        $hasEmail2FA = optional($user)->two_factor_via_email;

        if (Fortify::confirmsTwoFactorAuthentication()) {
            if ($usesTwoFactor && ($hasApp2FA || $hasEmail2FA)) {
                return $this->twoFactorChallengeResponse($request, $user);
            }
            return $next($request);
        }

        if ($usesTwoFactor && (optional($user)->two_factor_secret || $hasEmail2FA)) {
            return $this->twoFactorChallengeResponse($request, $user);
        }

        return $next($request);
    }
}
