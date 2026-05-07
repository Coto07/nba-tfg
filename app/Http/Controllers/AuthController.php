<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|min:3|max:50',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'name.min'           => 'El nombre debe tener al menos 3 caracteres.',
            'email.required'     => 'El email es obligatorio.',
            'email.unique'       => 'Este email ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', '¡Bienvenido ' . $user->name . '!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'El email es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('home')
                ->with('success', '¡Bienvenido de nuevo, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email o contraseña incorrectos.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')
            ->with('success', 'Sesión cerrada correctamente.');
    }

    public function profile()
    {
        $user = Auth::user();

        $favorites = $user->favorites()
            ->with('favorable')
            ->get();

        $favoritePlayers = $favorites
            ->filter(fn($f) => $f->favorable_type === 'App\\Models\\Player')
            ->map(fn($f) => $f->favorable)
            ->filter();

        $favoriteTeams = $favorites
            ->filter(fn($f) => $f->favorable_type === 'App\\Models\\Team')
            ->map(fn($f) => $f->favorable)
            ->filter();

        $simulations = \App\Models\Simulation::with(['homeTeam', 'awayTeam'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('auth.profile', compact(
            'user', 'favoritePlayers', 'favoriteTeams', 'simulations'
        ));
    }
}