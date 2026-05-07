<?php

namespace App\Http\Controllers;

use App\Models\Simulation;
use App\Models\Team;

class SimulationHistoryController extends Controller
{
    public function index()
    {
        $simulations = Simulation::with(['homeTeam', 'awayTeam'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Estadísticas globales de simulaciones
        $totalSims = Simulation::count();

        // Equipo con más victorias simuladas
        $allSims = Simulation::all();
        $wins    = [];

        foreach ($allSims as $sim) {
            $winnerId = $sim->home_win_probability >= $sim->away_win_probability
                ? $sim->home_team_id
                : $sim->away_team_id;

            $wins[$winnerId] = ($wins[$winnerId] ?? 0) + 1;
        }

        arsort($wins);
        $topTeams = [];
        foreach (array_slice($wins, 0, 5, true) as $teamId => $count) {
            $team = Team::find($teamId);
            if ($team) {
                $topTeams[] = ['team' => $team, 'wins' => $count];
            }
        }

        // Promedio de puntos
        $avgHomeScore = round(Simulation::avg('home_score') ?? 0, 1);
        $avgAwayScore = round(Simulation::avg('away_score') ?? 0, 1);

        return view('simulations.history', compact(
            'simulations',
            'totalSims',
            'topTeams',
            'avgHomeScore',
            'avgAwayScore'
        ));
    }

    public function destroy(Simulation $simulation)
    {
        $simulation->delete();
        return redirect()->route('simulations.history')
            ->with('success', 'Simulación eliminada.');
    }
}