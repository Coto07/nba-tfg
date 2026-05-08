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

    $favorites = $user->favorites()->with('favorable')->get();

    $favoritePlayers = $favorites
        ->filter(fn($f) => $f->favorable_type === 'App\\Models\\Player')
        ->map(fn($f) => $f->favorable)
        ->filter()
        ->load('team');

    $favoriteTeams = $favorites
        ->filter(fn($f) => $f->favorable_type === 'App\\Models\\Team')
        ->map(fn($f) => $f->favorable)
        ->filter();

    // Estadísticas del usuario
    $totalSimulations = \App\Models\Simulation::count();
    $totalFavorites   = $favorites->count();

    // Última simulación
    $lastSimulation = \App\Models\Simulation::with(['homeTeam', 'awayTeam'])
        ->orderBy('created_at', 'desc')
        ->first();

    // Equipo más simulado
    $allSims  = \App\Models\Simulation::all();
    $teamCount = [];
    foreach ($allSims as $sim) {
        $teamCount[$sim->home_team_id] = ($teamCount[$sim->home_team_id] ?? 0) + 1;
        $teamCount[$sim->away_team_id] = ($teamCount[$sim->away_team_id] ?? 0) + 1;
    }
    arsort($teamCount);
    $mostSimulatedTeam = !empty($teamCount)
        ? \App\Models\Team::find(array_key_first($teamCount))
        : null;

    // Últimas 5 simulaciones
    $recentSimulations = \App\Models\Simulation::with(['homeTeam', 'awayTeam'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    return view('auth.profile', compact(
        'user',
        'favoritePlayers',
        'favoriteTeams',
        'totalSimulations',
        'totalFavorites',
        'lastSimulation',
        'mostSimulatedTeam',
        'recentSimulations'
    ));

}

public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'password'         => 'required|min:6|confirmed',
    ], [
        'current_password.required' => 'La contraseña actual es obligatoria.',
        'password.required'         => 'La nueva contraseña es obligatoria.',
        'password.min'              => 'La contraseña debe tener al menos 6 caracteres.',
        'password.confirmed'        => 'Las contraseñas no coinciden.',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
    }

    $user->update([
        'password' => Hash::make($request->password)
    ]);

    return back()->with('success', 'Contraseña actualizada correctamente.');
}

public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|min:3|max:50',
    ], [
        'name.required' => 'El nombre es obligatorio.',
        'name.min'      => 'El nombre debe tener al menos 3 caracteres.',
    ]);

    Auth::user()->update([
        'name' => $request->name,
    ]);

    return back()->with('success', 'Perfil actualizado correctamente.');
}

public function deleteAccount(Request $request)
{
    $request->validate([
        'password' => 'required',
    ], [
        'password.required' => 'Debes confirmar tu contraseña para eliminar la cuenta.',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors(['password' => 'La contraseña no es correcta.']);
    }

    Auth::logout();
    $user->delete();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')
        ->with('success', 'Tu cuenta ha sido eliminada correctamente.');
}
}