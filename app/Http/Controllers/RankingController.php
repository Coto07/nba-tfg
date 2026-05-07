<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerStat;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $category  = $request->get('category', 'pts');
        $position  = $request->get('position', '');
        $conference = $request->get('conference', '');

        $validCategories = ['pts', 'reb', 'ast', 'stl', 'blk', 'min', 'fg_pct', 'fg3_pct', 'ft_pct'];
        if (!in_array($category, $validCategories)) {
            $category = 'pts';
        }

        $query = Player::with(['team', 'currentStats', 'activeInjury'])
            ->whereHas('currentStats', function ($q) use ($category) {
                $q->where($category, '>', 0)
                  ->where('games_played', '>=', 10);
            });

        if ($position) {
            $query->where('position', $position);
        }

        if ($conference) {
            $query->whereHas('team', function ($q) use ($conference) {
                $q->where('conference', $conference);
            });
        }

        $players = $query->get()
            ->sortByDesc(fn($p) => $p->currentStats?->{$category} ?? 0)
            ->take(25)
            ->values();

        $categories = [
            'pts'     => ['label' => 'Anotadores',    'icon' => '🏀', 'unit' => 'pts'],
            'reb'     => ['label' => 'Reboteadores',   'icon' => '📊', 'unit' => 'reb'],
            'ast'     => ['label' => 'Asistencias',    'icon' => '🎯', 'unit' => 'ast'],
            'stl'     => ['label' => 'Robos',          'icon' => '✋', 'unit' => 'stl'],
            'blk'     => ['label' => 'Tapones',        'icon' => '🛡️', 'unit' => 'blk'],
            'min'     => ['label' => 'Minutos',        'icon' => '⏱️', 'unit' => 'min'],
            'fg_pct'  => ['label' => 'FG%',            'icon' => '🎱', 'unit' => '%'],
            'fg3_pct' => ['label' => '3P%',            'icon' => '3️⃣', 'unit' => '%'],
            'ft_pct'  => ['label' => 'TL%',            'icon' => '🆓', 'unit' => '%'],
        ];

        return view('rankings.index', compact('players', 'categories', 'category', 'position', 'conference'));
    }
}