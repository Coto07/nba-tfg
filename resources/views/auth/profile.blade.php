@extends('layouts.app')

@section('title', 'Mi Perfil - NBA Simulator')

@section('styles')
<style>
    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f8c200;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
        color: #000;
    }
    .section-title {
        font-size: 1rem;
        font-weight: bold;
        color: #f8c200;
        border-left: 3px solid #f8c200;
        padding-left: 10px;
        margin-bottom: 16px;
    }
</style>
@endsection

@section('content')

{{-- CABECERA PERFIL --}}
<div class="card p-4 mb-4">
    <div class="d-flex align-items-center gap-4">
        <div class="profile-avatar">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <h2 class="text-warning fw-bold mb-1">{{ $user->name }}</h2>
            <div class="text-secondary">{{ $user->email }}</div>
            <div class="mt-2">
                <span class="badge {{ $user->isAdmin() ? 'bg-danger' : 'bg-secondary' }}">
                    {{ $user->isAdmin() ? 'Administrador' : 'Usuario' }}
                </span>
                <span class="badge bg-dark border border-secondary ms-2">
                    Miembro desde {{ $user->created_at->format('M Y') }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- EQUIPOS FAVORITOS --}}
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="section-title">
                ⭐ Equipos favoritos
                <span class="badge bg-secondary ms-2">{{ $favoriteTeams->count() }}</span>
            </div>
            @if($favoriteTeams->count() > 0)
                <div class="row g-2">
                    @foreach($favoriteTeams as $team)
                    <div class="col-4 text-center">
                        <a href="{{ route('teams.show', $team) }}" class="text-decoration-none">
                            <img src="{{ $team->logo_url }}"
                                 style="width:50px;height:50px;object-fit:contain;">
                            <div class="text-white small mt-1">{{ $team->abbreviation }}</div>
                        </a>
                        <form method="POST"
                              action="{{ route('favorites.team', $team) }}"
                              class="mt-1">
                            @csrf
                            <button type="submit"
                                    class="btn btn-outline-danger btn-sm"
                                    style="font-size:0.7rem;padding:2px 8px;">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-3">
                    <i class="bi bi-star fs-2 text-secondary"></i>
                    <p class="text-secondary small mt-2">
                        No tienes equipos favoritos todavía.
                    </p>
                    <a href="{{ route('teams.index') }}"
                       class="btn btn-outline-warning btn-sm">Ver equipos</a>
                </div>
            @endif
        </div>
    </div>

    {{-- JUGADORES FAVORITOS --}}
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="section-title">
                ⭐ Jugadores favoritos
                <span class="badge bg-secondary ms-2">{{ $favoritePlayers->count() }}</span>
            </div>
            @if($favoritePlayers->count() > 0)
                @foreach($favoritePlayers as $player)
                <div class="d-flex align-items-center gap-3 py-2 border-bottom border-secondary">
                    <div style="width:36px;height:36px;background:#f8c200;border-radius:50%;
                                display:flex;align-items:center;justify-content:center;
                                font-weight:bold;color:#000;flex-shrink:0;">
                        {{ strtoupper(substr($player->first_name, 0, 1)) }}
                    </div>
                    <div class="flex-fill">
                        <a href="{{ route('players.show', $player) }}"
                           class="text-white text-decoration-none fw-bold small">
                            {{ $player->full_name }}
                        </a>
                        <div class="text-secondary" style="font-size:0.75rem;">
                            {{ $player->team?->abbreviation }} · {{ $player->position }}
                        </div>
                    </div>
                    <form method="POST"
                          action="{{ route('favorites.player', $player) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                </div>
                @endforeach
            @else
                <div class="text-center py-3">
                    <i class="bi bi-star fs-2 text-secondary"></i>
                    <p class="text-secondary small mt-2">
                        No tienes jugadores favoritos todavía.
                    </p>
                    <a href="{{ route('players.index') }}"
                       class="btn btn-outline-warning btn-sm">Ver jugadores</a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection