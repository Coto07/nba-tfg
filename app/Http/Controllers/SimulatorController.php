<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Simulation;
use App\Services\SimulatorService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SimulatorController extends Controller
{
    public function index()
    {
        $teams = Team::whereIn('abbreviation', [
            'ATL','BOS','BKN','CHA','CHI','CLE','DAL','DEN',
            'DET','GSW','HOU','IND','LAC','LAL','MEM','MIA',
            'MIL','MIN','NOP','NYK','OKC','ORL','PHI','PHX',
            'POR','SAC','SAS','TOR','UTA','WAS'
        ])->orderBy('full_name')->get();

        $recentSimulations = Simulation::with(['homeTeam', 'awayTeam'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('simulator.index', compact('teams', 'recentSimulations'));
    }

    public function simulate(Request $request, SimulatorService $simulator)
    {
        $request->validate([
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id',
        ], [
            'different' => 'Los equipos local y visitante deben ser diferentes.',
        ]);

        $home = Team::findOrFail($request->home_team_id);
        $away = Team::findOrFail($request->away_team_id);

        $result = $simulator->simulate($home, $away);

        // Guardar simulación en BD
        $simulation = Simulation::create([
            'home_team_id'         => $home->id,
            'away_team_id'         => $away->id,
            'home_score'           => $result['home_score'],
            'away_score'           => $result['away_score'],
            'home_win_probability' => $result['home_win_prob'],
            'away_win_probability' => $result['away_win_prob'],
            'result_details'       => [
                'home_strength' => $result['home_strength'],
                'away_strength' => $result['away_strength'],
                'quarters'      => $result['quarters'],
            ],
        ]);

        return view('simulator.result', compact('result', 'simulation'));
    }

    public function exportPdf(Simulation $simulation)
    {
        $simulation->load(['homeTeam', 'awayTeam']);

        $pdf = Pdf::loadView('simulator.pdf', compact('simulation'))
            ->setPaper('a4', 'portrait');

        $filename = 'simulacion-' .
            $simulation->homeTeam->abbreviation . '-vs-' .
            $simulation->awayTeam->abbreviation . '-' .
            $simulation->created_at->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}