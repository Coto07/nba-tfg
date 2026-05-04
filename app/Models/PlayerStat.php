<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerStat extends Model
{
    protected $fillable = [
        'player_id', 'season', 'games_played',
        'pts', 'reb', 'ast', 'stl', 'blk',
        'fg_pct', 'fg3_pct', 'ft_pct', 'min', 'turnover'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}