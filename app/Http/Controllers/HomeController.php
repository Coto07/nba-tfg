<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerStat;
use App\Models\Team;
use App\Models\Injury;
use App\Models\Simulation;

class HomeController extends Controller
{
    public function index()
    {

        // Estadísticas generales
        $totalPlayers     = Player::whereHas('currentStats')->count();
        $totalTeams = Team::whereIn('abbreviation', [
            'ATL','BOS','BKN','CHA','CHI','CLE','DAL','DEN',
            'DET','GSW','HOU','IND','LAC','LAL','MEM','MIA',
            'MIL','MIN','NOP','NYK','OKC','ORL','PHI','PHX',
            'POR','SAC','SAS','TOR','UTA','WAS'
        ])->count();
        $totalSimulations = Simulation::count();
        $totalInjuries    = Injury::where('active', true)->count();

        // Top 5 anotadores
        $topScorers = Player::with(['team', 'currentStats'])
            ->whereHas('currentStats')
            ->get()
            ->sortByDesc(fn($p) => $p->currentStats->pts ?? 0)
            ->take(5)
            ->values();

        // Top 5 reboteadores
        $topRebounders = Player::with(['team', 'currentStats'])
            ->whereHas('currentStats')
            ->get()
            ->sortByDesc(fn($p) => $p->currentStats->reb ?? 0)
            ->take(5)
            ->values();

        // Top 5 asistencias
        $topAssists = Player::with(['team', 'currentStats'])
            ->whereHas('currentStats')
            ->get()
            ->sortByDesc(fn($p) => $p->currentStats->ast ?? 0)
            ->take(5)
            ->values();

        // Últimas simulaciones
        $recentSimulations = Simulation::with(['homeTeam', 'awayTeam'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Lesiones activas recientes
        $recentInjuries = Injury::with(['player.team'])
            ->where('active', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Equipo con más simulaciones ganadas
        $mostWins = Simulation::selectRaw('
            CASE
                WHEN home_win_probability > away_win_probability THEN home_team_id
                ELSE away_team_id
            END as team_id,
            COUNT(*) as wins
        ')
        ->groupBy('team_id')
        ->orderByDesc('wins')
        ->with('homeTeam')
        ->take(1)
        ->get();

        return view('home', compact(
            'totalPlayers',
            'totalTeams',
            'totalSimulations',
            'totalInjuries',
            'topScorers',
            'topRebounders',
            'topAssists',
            'recentSimulations',
            'recentInjuries'
        ));
    }
}