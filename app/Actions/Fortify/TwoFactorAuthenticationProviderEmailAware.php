<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider as Contract;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthenticationProviderEmailAware implements Contract
{
    public const EMAIL_SECRET = 'email';

    protected TwoFactorAuthenticationProvider $default;
    protected Request $request;

    public function __construct(Google2FA $engine, ?\Illuminate\Contracts\Cache\Repository $cache, Request $request)
    {
        $this->default = new TwoFactorAuthenticationProvider($engine, $cache);
        $this->request = $request;
    }

    public function generateSecretKey(int $secretLength = 16): string
    {
        return $this->default->generateSecretKey($secretLength);
    }

    public function qrCodeUrl($companyName, $companyEmail, $secret)
    {
        return $this->default->qrCodeUrl($companyName, $companyEmail, $secret);
    }

    public function verify($secret, $code)
    {
        if ($secret === self::EMAIL_SECRET) {
            $userId = $this->request->session()->get('login.id');
            if (! $userId) {
                return false;
            }
            $cacheKey = '2fa_email_code_' . $userId;
            $stored = Cache::get($cacheKey);
            $valid = $stored && hash_equals((string) $stored, (string) $code);
            if ($valid) {
                Cache::forget($cacheKey);
            }
            return $valid;
        }

        return $this->default->verify($secret, $code);
    }
}
