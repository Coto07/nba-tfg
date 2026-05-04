<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;

Route::get('/', fn() => view('home'))->name('home');

// Equipos
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');

// Jugadores
Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
Route::get('/players/{player}', [PlayerController::class, 'show'])->name('players.show');

// Rutas temporales
Route::get('/injuries', fn() => view('coming-soon', ['section' => 'Lesiones']))->name('injuries.index');
Route::get('/simulator', fn() => view('coming-soon', ['section' => 'Simulador']))->name('simulator.index');