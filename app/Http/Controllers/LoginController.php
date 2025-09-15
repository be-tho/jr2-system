<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function index()
    {
        return view('sections.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            return to_route('home.index')->with('success', 'Login realizado con éxito');
        } else {
            return to_route('login.index')->with('error', 'Credenciales incorrectas');
        }
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return to_route('login.index')->with('success', 'Sesión cerrada con éxito');
    }
}