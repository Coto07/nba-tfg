<?php

namespace App\Http\Controllers;

use App\Models\Injury;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class InjuryController extends Controller
{
    public function index()
    {
        $injuries = Injury::with(['player.team'])
            ->where('active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $players = Player::with('team')
            ->whereHas('currentStats')
            ->orderBy('last_name')
            ->get();

        return view('injuries.index', compact('injuries', 'players'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'player_id'       => 'required|exists:players,id',
            'description'     => 'required|string|max:255',
            'status'          => 'required|in:out,questionable,day-to-day',
            'injured_at'      => 'required|date',
            'expected_return' => 'nullable|date|after:injured_at',
        ]);

        // Desactivar lesión anterior si existe
        Injury::where('player_id', $request->player_id)
            ->where('active', true)
            ->update(['active' => false]);

        Injury::create([
            'player_id'       => $request->player_id,
            'description'     => $request->description,
            'status'          => $request->status,
            'injured_at'      => $request->injured_at,
            'expected_return' => $request->expected_return,
            'active'          => true,
        ]);

        return redirect()->route('injuries.index')
            ->with('success', 'Lesión registrada correctamente.');
    }

    public function destroy(Injury $injury)
    {
        $injury->update(['active' => false]);

        return redirect()->route('injuries.index')
            ->with('success', 'Jugador marcado como recuperado.');
    }
}