<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class PasswordChangeController extends Controller
{
    public function sendCode(Request $request)
    {
        $user = $request->user();
        $lockKey = 'password_change_sent_' . $user->getKey();
        if (Cache::has($lockKey)) {
            return back()->with('status', 'password-change-code-sent');
        }

        $code = (string) Str::padLeft((string) random_int(0, 999999), 6, '0');
        $cacheKey = 'password_change_code_' . $user->getKey();
        Cache::put($cacheKey, $code, now()->addMinutes(10));
        Cache::put($lockKey, true, now()->addSeconds(25));

        $user->notify(new \App\Notifications\PasswordChangeCodeNotification($code));

        return back()->with('status', 'password-change-code-sent');
    }

    public function changeWithCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.size' => 'El código debe tener 6 dígitos.',
            'current_password.current_password' => 'La contraseña actual no es correcta.',
        ]);

        $user = $request->user();
        $cacheKey = 'password_change_code_' . $user->getKey();
        $cachedCode = Cache::get($cacheKey);

        if ($cachedCode === null || $cachedCode !== $request->input('code')) {
            return back()->withErrors(['code' => 'El código no es válido o ha expirado. Solicite uno nuevo.']);
        }

        Cache::forget($cacheKey);
        $user->forceFill([
            'password' => Hash::make($request->input('password')),
        ])->save();

        return back()->with('status', 'password-changed');
    }
}
