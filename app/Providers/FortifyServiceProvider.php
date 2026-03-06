<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\RedirectIfTwoFactorAuthenticatableWithEmail;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\TwoFactorAuthenticationProviderEmailAware;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Listeners\SendTwoFactorEmailCode;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Event;
use Laravel\Fortify\Events\TwoFactorAuthenticationChallenged;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\LoginRateLimiter;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider as TwoFactorProviderContract;
use Laravel\Fortify\Contracts\RedirectsIfTwoFactorAuthenticatable as RedirectsTwoFactorContract;
use Illuminate\Support\ServiceProvider;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        $this->app->singleton(TwoFactorProviderContract::class, TwoFactorAuthenticationProviderEmailAware::class);
        $this->app->singleton(RedirectsTwoFactorContract::class, function ($app) {
            return new RedirectIfTwoFactorAuthenticatableWithEmail(
                $app->make(StatefulGuard::class),
                $app->make(LoginRateLimiter::class)
            );
        });

        $this->app->singleton(LoginResponseContract::class, \App\Http\Responses\LoginResponse::class);
    }

    public function boot(): void
    {
        Event::listen(TwoFactorAuthenticationChallenged::class, SendTwoFactorEmailCode::class);
    }
}
