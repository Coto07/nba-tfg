<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function togglePlayer(Player $player)
    {
        $user     = Auth::user();
        $existing = Favorite::where('user_id', $user->id)
            ->where('favorable_type', 'App\\Models\\Player')
            ->where('favorable_id', $player->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = $player->full_name . ' eliminado de favoritos.';
        } else {
            Favorite::create([
                'user_id'        => $user->id,
                'favorable_type' => 'App\\Models\\Player',
                'favorable_id'   => $player->id,
            ]);
            $message = $player->full_name . ' añadido a favoritos.';
        }

        return back()->with('success', $message);
    }

    public function toggleTeam(Team $team)
    {
        $user     = Auth::user();
        $existing = Favorite::where('user_id', $user->id)
            ->where('favorable_type', 'App\\Models\\Team')
            ->where('favorable_id', $team->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = $team->full_name . ' eliminado de favoritos.';
        } else {
            Favorite::create([
                'user_id'        => $user->id,
                'favorable_type' => 'App\\Models\\Team',
                'favorable_id'   => $team->id,
            ]);
            $message = $team->full_name . ' añadido a favoritos.';
        }

        return back()->with('success', $message);
    }
}