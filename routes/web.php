<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\InjuryController;
use App\Http\Controllers\SimulatorController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\SimulationHistoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SearchController;

// Rutas públicas (sin login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Rutas protegidas (requieren login)
Route::middleware('auth')->group(function () {

    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Equipos
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');

    // Jugadores
    Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
    Route::get('/players/{player}', [PlayerController::class, 'show'])->name('players.show');

    // Lesiones
    Route::get('/injuries', [InjuryController::class, 'index'])->name('injuries.index');
    Route::post('/injuries', [InjuryController::class, 'store'])->name('injuries.store');
    Route::delete('/injuries/{injury}', [InjuryController::class, 'destroy'])->name('injuries.destroy');

    // Simulador
    Route::get('/simulator', [SimulatorController::class, 'index'])->name('simulator.index');
    Route::post('/simulator', [SimulatorController::class, 'simulate'])->name('simulator.simulate');
    Route::get('/simulator/{simulation}/pdf', [SimulatorController::class, 'exportPdf'])->name('simulator.pdf');

    // Comparador
    Route::get('/compare', [CompareController::class, 'index'])->name('compare.index');
    Route::post('/compare', [CompareController::class, 'compare'])->name('compare.compare');

    // Rankings
    Route::get('/rankings', [RankingController::class, 'index'])->name('rankings.index');

    // Historial simulaciones
    Route::get('/simulations', [SimulationHistoryController::class, 'index'])->name('simulations.history');
    Route::delete('/simulations/{simulation}', [SimulationHistoryController::class, 'destroy'])->name('simulations.destroy');

    // Perfil y logout
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile/delete', [AuthController::class, 'deleteAccount'])->name('profile.delete');

    // Favoritos
    Route::post('/favorites/player/{player}', [FavoriteController::class, 'togglePlayer'])->name('favorites.player');
    Route::post('/favorites/team/{team}', [FavoriteController::class, 'toggleTeam'])->name('favorites.team');

    // Buscador global
    Route::get('/search', [SearchController::class, 'search'])->name('search');
});