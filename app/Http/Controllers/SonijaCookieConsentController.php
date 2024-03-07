<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SonijaCookieConsentController extends Controller
{
    public function show()
    {
        return view('cookie_consent.show');
    }

    public function accept(Request $request)
    {
        // Ustaw flagę cookie_accepted w sesji użytkownika
        $request->session()->put('cookie_accepted', true);

        // Przekieruj użytkownika na stronę główną lub inną docelową stronę
        return redirect()->route('home');
    }
}
