<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json(['players' => [], 'teams' => []]);
        }

        $teams = Team::whereIn('abbreviation', [
            'ATL','BOS','BKN','CHA','CHI','CLE','DAL','DEN',
            'DET','GSW','HOU','IND','LAC','LAL','MEM','MIA',
            'MIL','MIN','NOP','NYK','OKC','ORL','PHI','PHX',
            'POR','SAC','SAS','TOR','UTA','WAS'
        ])
        ->where(function ($q) use ($query) {
            $q->where('full_name', 'like', '%' . $query . '%')
              ->orWhere('city', 'like', '%' . $query . '%')
              ->orWhere('abbreviation', 'like', '%' . $query . '%');
        })
        ->take(5)
        ->get()
        ->map(fn($t) => [
            'id'         => $t->id,
            'full_name'  => $t->full_name,
            'conference' => $t->conference,
            'division'   => $t->division,
            'logo_url'   => $t->logo_url,
        ]);

        $players = Player::with('team')
            ->whereHas('currentStats')
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'like', '%' . $query . '%')
                  ->orWhere('last_name', 'like', '%' . $query . '%')
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $query . '%']);
            })
            ->take(6)
            ->get()
            ->map(fn($p) => [
                'id'         => $p->id,
                'full_name'  => $p->full_name,
                'first_name' => $p->first_name,
                'position'   => $p->position,
                'team'       => $p->team?->abbreviation,
            ]);

        return response()->json([
            'players' => $players,
            'teams'   => $teams,
        ]);
    }
}