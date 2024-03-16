<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;


class SonijaCookieConsentController extends Controller
{
    public function show()
    {
        return view('cookie_consent.show');
    }

    public function accept(Request $request): RedirectResponse
    {
        // Utwórz ciasteczko, które będzie przechowywać informację o zaakceptowaniu ciasteczek
        $cookie = cookie('cookie_accepted', true, 60 * 24 * 365); // Ciasteczko ważne przez 1 rok
    
        // Przekieruj użytkownika na stronę główną lub inną docelową stronę z ustawionym ciasteczkiem
        return redirect()->route('home')->withCookie($cookie);
    }
}
