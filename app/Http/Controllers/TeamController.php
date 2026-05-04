<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $query = Team::whereIn('abbreviation', [
            'ATL','BOS','BKN','CHA','CHI','CLE','DAL','DEN',
            'DET','GSW','HOU','IND','LAC','LAL','MEM','MIA',
            'MIL','MIN','NOP','NYK','OKC','ORL','PHI','PHX',
            'POR','SAC','SAS','TOR','UTA','WAS'
        ])->withCount('players');

        // Filtro por conferencia
        if ($request->filled('conference')) {
            $query->where('conference', $request->conference);
        }

        // Filtro por búsqueda
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%')
                  ->orWhere('abbreviation', 'like', '%' . $request->search . '%');
            });
        }

        $teams = $query->orderBy('full_name')->get();

        return view('teams.index', compact('teams'));
    }

    public function show(Team $team)
    {
        $players = $team->players()
            ->with(['currentStats', 'activeInjury'])
            ->get()
            ->sortByDesc(fn($p) => $p->currentStats?->pts ?? 0);

        $teamStat = $team->currentStats;

        return view('teams.show', compact('team', 'players', 'teamStat'));
    }
}