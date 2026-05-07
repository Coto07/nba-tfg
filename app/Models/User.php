<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}