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

        if ($request->filled('conference')) {
            $query->where('conference', $request->conference);
        }

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

        $playersWithStats = $players->filter(fn($p) => $p->currentStats !== null);

        $teamAverages = [
            'pts'     => round($playersWithStats->avg(fn($p) => $p->currentStats->pts) ?? 0, 1),
            'reb'     => round($playersWithStats->avg(fn($p) => $p->currentStats->reb) ?? 0, 1),
            'ast'     => round($playersWithStats->avg(fn($p) => $p->currentStats->ast) ?? 0, 1),
            'stl'     => round($playersWithStats->avg(fn($p) => $p->currentStats->stl) ?? 0, 1),
            'blk'     => round($playersWithStats->avg(fn($p) => $p->currentStats->blk) ?? 0, 1),
            'fg_pct'  => round($playersWithStats->avg(fn($p) => $p->currentStats->fg_pct) ?? 0, 3),
            'fg3_pct' => round($playersWithStats->avg(fn($p) => $p->currentStats->fg3_pct) ?? 0, 3),
            'ft_pct'  => round($playersWithStats->avg(fn($p) => $p->currentStats->ft_pct) ?? 0, 3),
        ];

        $topScorer    = $playersWithStats->sortByDesc(fn($p) => $p->currentStats->pts)->first();
        $topRebounder = $playersWithStats->sortByDesc(fn($p) => $p->currentStats->reb)->first();
        $topAssister  = $playersWithStats->sortByDesc(fn($p) => $p->currentStats->ast)->first();
        $topDefender  = $playersWithStats->sortByDesc(fn($p) => ($p->currentStats->stl + $p->currentStats->blk))->first();

        $injuredPlayers = $players->filter(fn($p) => $p->activeInjury !== null);

        $recentSims = \App\Models\Simulation::with(['homeTeam', 'awayTeam'])
            ->where('home_team_id', $team->id)
            ->orWhere('away_team_id', $team->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('teams.show', compact(
            'team', 'players', 'teamStat',
            'teamAverages', 'topScorer', 'topRebounder',
            'topAssister', 'topDefender', 'injuredPlayers',
            'recentSims'
        ));
    }

    public function edit(Team $team)
    {
        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'full_name'  => 'required|string|max:100',
            'city'       => 'required|string|max:100',
            'name'       => 'required|string|max:100',
            'conference' => 'required|in:East,West',
            'division'   => 'required|string|max:100',
        ]);

        $team->update([
            'full_name'  => $request->full_name,
            'city'       => $request->city,
            'name'       => $request->name,
            'conference' => $request->conference,
            'division'   => $request->division,
        ]);

        return redirect()->route('teams.show', $team)
            ->with('success', 'Equipo actualizado correctamente.');
    }
}