<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'api_id', 'team_id', 'first_name', 'last_name',
        'position', 'jersey_number', 'height', 'weight',
        'college', 'country'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function stats()
    {
        return $this->hasMany(PlayerStat::class);
    }

    public function currentStats()
    {
        return $this->hasOne(PlayerStat::class)->latestOfMany();
    }

    public function injuries()
    {
        return $this->hasMany(Injury::class);
    }

    public function activeInjury()
    {
        return $this->hasOne(Injury::class)->where('active', true)->latest();
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isInjured()
    {
        return $this->injuries()->where('active', true)->exists();
    }

    public function favorites()
{
    return $this->morphMany(Favorite::class, 'favorable');
}

public function isFavoritedBy(?User $user): bool
{
    if (!$user) return false;
    return $this->favorites()->where('user_id', $user->id)->exists();
}

}