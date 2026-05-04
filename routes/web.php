<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('home'))->name('home');

Route::get('/teams', fn() => view('coming-soon', ['section' => 'Equipos']))->name('teams.index');
Route::get('/players', fn() => view('coming-soon', ['section' => 'Jugadores']))->name('players.index');
Route::get('/injuries', fn() => view('coming-soon', ['section' => 'Lesiones']))->name('injuries.index');
Route::get('/simulator', fn() => view('coming-soon', ['section' => 'Simulador']))->name('simulator.index');