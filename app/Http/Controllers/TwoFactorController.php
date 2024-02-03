<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use App\Models\User;


class TwoFactorController extends Controller
{
    public function index()
    {
        return view('auth.2fa');
    }

    public function verify(Request $request)
    {
        $userId = $request->session()->get('2fa:user:id');
    
        if (!$userId) {
            // Brak ID użytkownika w sesji, przekieruj do logowania
            return redirect()->route('login');
        }
    
        $user = User::find($userId);
    
        if (!$user) {
            // Użytkownik nie został znaleziony, przekieruj do logowania
            return redirect()->route('login');
        }
    
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->input('2fa_code'));
    
        if ($valid) {
            // Logowanie i przekierowanie
            Auth::login($user);
            $request->session()->forget('2fa:user:id');
    
            return redirect()->intended('home');
        }
    
        // Błędny kod, wróć do formularza 2FA z błędem
        return back()->withErrors(['2fa_code' => 'The provided 2FA code is not correct. Try again.']);
    }
}
