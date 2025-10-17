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
        try {
            $credentials = $request->only(['email', 'password']);
            $remember = $request->boolean('remember');
            
            if (Auth::attempt($credentials, $remember)) {
                // Regenerar session ID para prevenir session fixation attacks
                $request->session()->regenerate();
                
                \Log::info('Login exitoso', [
                    'email' => $request->email,
                    'ip' => $request->ip(),
                    'remember' => $remember
                ]);
                
                return to_route('home.index')->with('success', 'Login realizado con éxito');
            }
            
            \Log::warning('Intento de login fallido', [
                'email' => $request->email,
                'ip' => $request->ip()
            ]);
            
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Credenciales incorrectas');
                
        } catch (\Exception $e) {
            \Log::error('Error en login', [
                'error' => $e->getMessage(),
                'email' => $request->email,
                'ip' => $request->ip()
            ]);
            
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Error al procesar el login. Inténtalo de nuevo.');
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