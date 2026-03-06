<?php

namespace App\Listeners;

use App\Actions\Fortify\TwoFactorAuthenticationProviderEmailAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Fortify\Events\TwoFactorAuthenticationChallenged;

class SendTwoFactorEmailCode
{
    public function handle(TwoFactorAuthenticationChallenged $event): void
    {
        $user = $event->user;

        $useEmail2FA = ! empty($user->two_factor_via_email);
        if (! $useEmail2FA && ! empty($user->two_factor_secret)) {
            try {
                $useEmail2FA = decrypt($user->two_factor_secret) === TwoFactorAuthenticationProviderEmailAware::EMAIL_SECRET;
            } catch (\Throwable $e) {
                // no es 'email'
            }
        }

        if (! $useEmail2FA) {
            return;
        }

        $lockKey = '2fa_email_sent_' . $user->getKey();
        if (Cache::has($lockKey)) {
            return;
        }

        $code = (string) Str::padLeft((string) random_int(0, 999999), 6, '0');
        $cacheKey = '2fa_email_code_' . $user->getKey();
        Cache::put($cacheKey, $code, now()->addMinutes(10));
        Cache::put($lockKey, true, now()->addSeconds(30));

        $user->notify(new \App\Notifications\TwoFactorCodeNotification($code));
    }
}
