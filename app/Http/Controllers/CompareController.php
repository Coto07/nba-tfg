<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index()
    {
        $players = Player::with('team')
            ->whereHas('currentStats')
            ->get()
            ->sortBy('last_name');

        return view('compare.index', compact('players'));
    }

    public function compare(Request $request)
    {
        $request->validate([
            'player1_id' => 'required|exists:players,id|different:player2_id',
            'player2_id' => 'required|exists:players,id',
        ], [
            'different' => 'Los jugadores deben ser diferentes.',
        ]);

        $player1 = Player::with(['team', 'currentStats', 'activeInjury'])
            ->findOrFail($request->player1_id);
        $player2 = Player::with(['team', 'currentStats', 'activeInjury'])
            ->findOrFail($request->player2_id);

        return view('compare.result', compact('player1', 'player2'));
    }
}