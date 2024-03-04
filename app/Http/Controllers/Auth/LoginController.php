<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


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

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where('email', $request->email)->first(); // Pobierz użytkownika na podstawie adresu e-mail
    
        $status = 'These credentials do not match our records.'; // Domyślny komunikat błędu
    
        // Sprawdź status użytkownika
        if ($user && $user->user_status !== 'active') {
            $status = 'Your account is disabled or blocked. Contact the administrator.';
            $key = 'email'; // Klucz dla komunikatu błędu pola email
        } elseif ($user && !Hash::check($request->password, $user->password)) {
            $status = 'The entered password is incorrect.';
            $key = 'password'; // Klucz dla komunikatu błędu pola hasła
        } else {
            $key = $this->username(); // Klucz dla domyślnego komunikatu błędu
        }
    
        throw ValidationException::withMessages([
            $key => [$status],
        ]);
    }
    

    protected function attemptLogin(Request $request)
    {
        // Próba logowania z podanymi danymi
        $credentials = $this->credentials($request);
        $credentials['user_status'] = 'active'; // Dodajemy warunek sprawdzający status użytkownika
        return Auth::attempt($credentials, $request->filled('remember'));
    }
}
