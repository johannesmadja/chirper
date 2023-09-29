<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function changeLanguage(string $locale) {
        // Stocker la langue choisis dans la session de l'utilisateur
        Session::put('local', $locale);
        // rediriger sur la page précédente 
        return redirect()->back();
    }
}
