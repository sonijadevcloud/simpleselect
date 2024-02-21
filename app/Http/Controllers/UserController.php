<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use App\Models\User;
use App\Models\Role;


class UserController extends Controller
{
    // Wyświetlanie formularza ustawień
    public function settings()
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        if (empty($user->google2fa_secret) || strlen($user->google2fa_secret) < 16) {
            $user->google2fa_secret = $google2fa->generateSecretKey();
            $user->save();
        }

        $QRImage = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        session(['QRImage' => $QRImage, 'temp_secret' => $user->google2fa_secret]);

        $user = Auth::user();
        return view('usersettings.settings', ['QRImage' => $QRImage, 'secret' => $user->google2fa_secret], compact('user'));

    }

    // Aktualizacja ustawień
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        // Walidacja danych
        $request->validate([
            'phone' => 'nullable|numeric',
            // 'description' => 'nullable|string',
            'position' => 'nullable|string',
            // 'twofactor' => 'nullable|string',
            'signature' => 'nullable|string',
            // Dodaj inne reguły walidacji zgodnie z potrzebami
        ]);

        // Aktualizacja danych użytkownika
        $user->phone = $request->phone;
        // $user->description = $request->description;
        $user->position = $request->position;
        // $user->two_factor_enabled = $request->twofactor;
        $user->signature = $request->signature;
        $user->save();

        return back()->with('success', 'Settings have been updated.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
        ]);

        $user = Auth::user();

        // Sprawdź, czy obecne hasło jest poprawne
        if (!Hash::check($request->current_password, $user->password)) {
            // Zwróć błąd, jeśli hasło nie jest poprawne
            return back()->withErrors(['current_password' => 'Current password is not correct. Try again']);
        }

        // Zmień hasło użytkownika
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'password has been changed');
    }

    public function verifyTwoFactor(Request $request)
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        // Odczytaj sekretny klucz z sesji
        $secret = $request->input('verify_code');
        $tempSecret = session('temp_secret');

        // Sprawdź, czy kod jest poprawny
        $valid = $google2fa->verifyKey($tempSecret, $request->input('verify_code'));

        if ($valid) {
            // Zapisz sekretny klucz w profilu użytkownika i włącz 2FA
            $user->google2fa_secret = $tempSecret;
            $user->google2fa_enabled = true; // Upewnij się, że masz takie pole w tabeli użytkowników
            $user->save();

            // Usuń tymczasowy sekret z sesji
            session()->forget('temp_secret');

            return redirect()->route('settings')->with('success', '2FA is enabled successfully.');
        } else {
            // Jeśli kod jest niepoprawny, wróć do ustawień z błędem
            return back()->withErrors(['verify_code' => 'Invalid verification code. Please try again.']);
        }
    }

    public function disableTwoFactor(Request $request)
    {
        $user = Auth::user();
        $user->google2fa_enabled = false;
        $user->google2fa_secret = null;
        $user->save();

        return redirect()->route('settings')->with('success', '2FA has been disabled.');
    }

    // Metoda wyświetlająca listę użytkowników
    public function index()
    {
        $roles = Role::all(); // Załóżmy, że masz model Role
        $users = User::paginate(5);
        return view('admin.users.index', compact('users'), compact('roles'));
    }

    // Metoda wyświetlająca formularz dodawania nowego użytkownika
    public function create()
    {
        // return view('admin.users.create');
    }

    // Metoda obsługująca dodawanie nowego użytkownika
    public function store(Request $request)
    {
        // Walidacja danych wejściowych
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'role' => 'required',
        ]);

        // Zapis nowego użytkownika
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role;
        $user->save();

        // Przekierowanie po zakończeniu
        return redirect()->route('users.index')->with('success', 'User has been created successfully.');
    }

    // Metoda wyświetlająca formularz edycji użytkownika
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Metoda obsługująca aktualizację danych użytkownika
    public function update(Request $request, User $user)
    {
        if ($request->has('password')) {
            // Walidacja nowego hasła
            $request->validate([
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/',
                ],
            ]);
    
            // Aktualizacja hasła
            $user->password = Hash::make($request->password);
        } else {
            // Aktualizacja innych danych użytkownika
            $user->fill($request->except('password'));
        }
    
        try {
            $user->save();
            return redirect()->route('users.index')->with('success', 'User information updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'There was an error editing the user.');
        }
    }

    // Metoda obsługująca usuwanie użytkownika
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User successfully removed.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'An error occurred while deleting a user.');
        }
    }


}



