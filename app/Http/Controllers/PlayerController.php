<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerStat;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $query = Player::with(['team', 'currentStats', 'activeInjury'])
            ->whereHas('currentStats');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                  ->orWhere('last_name', 'like', '%' . $search . '%')
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $search . '%']);
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

    public function create()
    {
        $teams = Team::whereIn('abbreviation', [
            'ATL','BOS','BKN','CHA','CHI','CLE','DAL','DEN',
            'DET','GSW','HOU','IND','LAC','LAL','MEM','MIA',
            'MIL','MIN','NOP','NYK','OKC','ORL','PHI','PHX',
            'POR','SAC','SAS','TOR','UTA','WAS'
        ])->orderBy('full_name')->get();

        return view('players.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'team_id'    => 'required|exists:teams,id',
            'position'   => 'required|in:PG,SG,SF,PF,C',
            'pts'        => 'required|numeric|min:0|max:50',
            'reb'        => 'required|numeric|min:0|max:30',
            'ast'        => 'required|numeric|min:0|max:30',
            'stl'        => 'required|numeric|min:0|max:10',
            'blk'        => 'required|numeric|min:0|max:10',
            'fg_pct'     => 'required|numeric|min:0|max:1',
            'fg3_pct'    => 'required|numeric|min:0|max:1',
            'ft_pct'     => 'required|numeric|min:0|max:1',
            'min'        => 'required|numeric|min:0|max:48',
            'games_played' => 'required|integer|min:0|max:82',
        ]);

        // Crear jugador
        $player = Player::create([
            'api_id'     => Player::max('api_id') + 1,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'team_id'    => $request->team_id,
            'position'   => $request->position,
            'height'     => $request->height,
            'weight'     => $request->weight,
            'college'    => $request->college,
            'country'    => $request->country,
        ]);

        // Crear estadísticas
        PlayerStat::create([
            'player_id'    => $player->id,
            'season'       => 2024,
            'games_played' => $request->games_played,
            'pts'          => $request->pts,
            'reb'          => $request->reb,
            'ast'          => $request->ast,
            'stl'          => $request->stl,
            'blk'          => $request->blk,
            'fg_pct'       => $request->fg_pct,
            'fg3_pct'      => $request->fg3_pct,
            'ft_pct'       => $request->ft_pct,
            'min'          => $request->min,
            'turnover'     => $request->turnover ?? 0,
        ]);

        return redirect()->route('players.show', $player)
            ->with('success', 'Jugador creado correctamente.');
    }

    public function edit(Player $player)
    {
        $teams = Team::whereIn('abbreviation', [
            'ATL','BOS','BKN','CHA','CHI','CLE','DAL','DEN',
            'DET','GSW','HOU','IND','LAC','LAL','MEM','MIA',
            'MIL','MIN','NOP','NYK','OKC','ORL','PHI','PHX',
            'POR','SAC','SAS','TOR','UTA','WAS'
        ])->orderBy('full_name')->get();

        $stats = $player->currentStats;

        return view('players.edit', compact('player', 'teams', 'stats'));
    }

    public function update(Request $request, Player $player)
    {
        $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'team_id'      => 'required|exists:teams,id',
            'position'     => 'required|in:PG,SG,SF,PF,C',
            'pts'          => 'required|numeric|min:0|max:50',
            'reb'          => 'required|numeric|min:0|max:30',
            'ast'          => 'required|numeric|min:0|max:30',
            'stl'          => 'required|numeric|min:0|max:10',
            'blk'          => 'required|numeric|min:0|max:10',
            'fg_pct'       => 'required|numeric|min:0|max:1',
            'fg3_pct'      => 'required|numeric|min:0|max:1',
            'ft_pct'       => 'required|numeric|min:0|max:1',
            'min'          => 'required|numeric|min:0|max:48',
            'games_played' => 'required|integer|min:0|max:82',
        ]);

        // Actualizar jugador
        $player->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'team_id'    => $request->team_id,
            'position'   => $request->position,
            'height'     => $request->height,
            'weight'     => $request->weight,
            'college'    => $request->college,
            'country'    => $request->country,
        ]);

        // Actualizar estadísticas
        PlayerStat::updateOrCreate(
            ['player_id' => $player->id, 'season' => 2024],
            [
                'games_played' => $request->games_played,
                'pts'          => $request->pts,
                'reb'          => $request->reb,
                'ast'          => $request->ast,
                'stl'          => $request->stl,
                'blk'          => $request->blk,
                'fg_pct'       => $request->fg_pct,
                'fg3_pct'      => $request->fg3_pct,
                'ft_pct'       => $request->ft_pct,
                'min'          => $request->min,
                'turnover'     => $request->turnover ?? 0,
            ]
        );

        return redirect()->route('players.show', $player)
            ->with('success', 'Jugador actualizado correctamente.');
    }

    public function destroy(Player $player)
    {
        $player->delete();

        return redirect()->route('players.index')
            ->with('success', 'Jugador eliminado correctamente.');
    }
}