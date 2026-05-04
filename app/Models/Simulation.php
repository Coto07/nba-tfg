<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{
    protected $fillable = [
        'home_team_id', 'away_team_id',
        'home_score', 'away_score',
        'home_win_probability', 'away_win_probability',
        'result_details'
    ];

    protected $casts = [
        'result_details' => 'array'
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}