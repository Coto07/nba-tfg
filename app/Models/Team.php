<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'api_id', 'name', 'city', 'abbreviation',
        'conference', 'division', 'full_name'
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function stats()
    {
        return $this->hasMany(TeamStat::class);
    }

    public function currentStats()
    {
        return $this->hasOne(TeamStat::class)->latestOfMany();
    }

    public function homeSimulations()
    {
        return $this->hasMany(Simulation::class, 'home_team_id');
    }

    public function awaySimulations()
    {
        return $this->hasMany(Simulation::class, 'away_team_id');
    }
}