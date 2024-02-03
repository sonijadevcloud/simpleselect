<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->google2fa_enabled) {
            // Wyloguj użytkownika, ale zachowaj jego ID w sesji
            Auth::logout();
            $request->session()->put('2fa:user:id', $user->id);

            // Przekieruj do strony weryfikacji 2FA
            return redirect()->route('2fa.index');
        }

        // Kontynuuj standardowe przekierowanie po zalogowaniu
        return redirect()->intended($this->redirectPath());
    }
}
