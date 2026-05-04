<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Injury extends Model
{
    protected $fillable = [
        'player_id', 'description', 'status',
        'injured_at', 'expected_return', 'active'
    ];

    protected $casts = [
        'injured_at' => 'date',
        'expected_return' => 'date',
        'active' => 'boolean'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'out'          => '<span class="badge bg-danger">Baja</span>',
            'questionable' => '<span class="badge bg-warning text-dark">Dudoso</span>',
            'day-to-day'   => '<span class="badge bg-info text-dark">Día a día</span>',
            default        => '<span class="badge bg-secondary">Desconocido</span>'
        };
    }
}