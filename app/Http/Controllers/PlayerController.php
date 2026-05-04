<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $query = Player::with(['team', 'currentStats', 'activeInjury'])
            ->whereHas('currentStats');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('team')) {
            $query->where('team_id', $request->team);
        }

        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        $players = $query->get()->sortByDesc(fn($p) => $p->currentStats?->pts ?? 0);
        $teams   = Team::whereIn('abbreviation', [
            'ATL','BOS','BKN','CHA','CHI','CLE','DAL','DEN',
            'DET','GSW','HOU','IND','LAC','LAL','MEM','MIA',
            'MIL','MIN','NOP','NYK','OKC','ORL','PHI','PHX',
            'POR','SAC','SAS','TOR','UTA','WAS'
        ])->orderBy('full_name')->get();

        return view('players.index', compact('players', 'teams'));
    }

    public function show(Player $player)
    {
        $player->load(['team', 'stats', 'activeInjury']);
        $stats = $player->currentStats;

        return view('players.show', compact('player', 'stats'));
    }
}