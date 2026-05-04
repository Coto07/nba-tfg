<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamStat extends Model
{
    protected $fillable = [
        'team_id', 'season', 'wins', 'losses',
        'ppg', 'opp_ppg', 'rpg', 'apg',
        'fg_pct', 'fg3_pct'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function getWinRateAttribute()
    {
        $total = $this->wins + $this->losses;
        return $total > 0 ? round(($this->wins / $total) * 100, 1) : 0;
    }
}