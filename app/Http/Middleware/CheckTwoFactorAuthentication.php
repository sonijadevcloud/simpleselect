<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckTwoFactorAuthentication
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Sprawdź, czy 2FA jest włączone i czy sesja ma oznaczenie potwierdzenia 2FA
        if ($user && $user->google2fa_enabled && !$request->session()->get('2fa', false)) {
            // Przekieruj do strony weryfikacji 2FA
            return redirect()->route('2fa.index');
        }

        return $next($request);
    }
}
