<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;

Route::get('/', fn() => view('home'))->name('home');

// Equipos
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');

// Rutas temporales
Route::get('/players', fn() => view('coming-soon', ['section' => 'Jugadores']))->name('players.index');
Route::get('/injuries', fn() => view('coming-soon', ['section' => 'Lesiones']))->name('injuries.index');
Route::get('/simulator', fn() => view('coming-soon', ['section' => 'Simulador']))->name('simulator.index');