<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\InjuryController;

Route::get('/', fn() => view('home'))->name('home');

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

// Rutas temporales
Route::get('/simulator', fn() => view('coming-soon', ['section' => 'Simulador']))->name('simulator.index');