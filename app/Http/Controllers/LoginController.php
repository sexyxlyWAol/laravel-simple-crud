<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request): RedirectResponse {
        $token = $request->query('token');
        if($token === "laravel-simple-crud"){
            session(['authenticated' => true]);
        }
        return redirect('/products');
    }

    public function logout(): RedirectResponse {
        session()->forget('authenticated');
        return redirect('/products');
    }
}
