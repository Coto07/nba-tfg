<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\InjuryController;
use App\Http\Controllers\SimulatorController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\RankingController;

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

// Comparador
Route::get('/compare', [CompareController::class, 'index'])->name('compare.index');
Route::post('/compare', [CompareController::class, 'compare'])->name('compare.compare');

// Rankings
Route::get('/rankings', [RankingController::class, 'index'])->name('rankings.index');