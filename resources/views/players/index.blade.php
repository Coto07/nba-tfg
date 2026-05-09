@extends('layouts.app')

@section('title', 'Jugadores - NBA Simulator')

@section('styles')
<style>
    .page-hero {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        background-image: url('https://images.unsplash.com/photo-1608245449230-4ac19066d2d0?w=1920&q=80');
        background-size: cover;
        background-position: center top;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .page-hero-overlay {
        position: relative;
        z-index: 2;
        padding: 50px 20px;
        width: 100%;
        background: rgba(0, 0, 0, 0.25);
    }
    .page-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(13,13,13,0.1) 0%, rgba(26,26,46,0.1) 100%);
        z-index: 1;
    }
</style>
@endsection

@section('content')
{{-- HERO JUGADORES --}}
<div class="page-hero text-center mb-5">
    <div class="page-hero-overlay">
        <h1 class="display-5 fw-bold text-warning mb-2">
            <i class="bi bi-person-fill me-2"></i>Jugadores NBA
        </h1>
        <p class="text-white mb-0">
            {{ $players->count() }} jugadores con estadísticas de la temporada 2023-24
        </p>
    </div>
</div>

{{-- Filtros --}}
<form method="GET" action="{{ route('players.index') }}" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control bg-dark text-white border-secondary"
               placeholder="Buscar jugador..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select name="team" class="form-select bg-dark text-white border-secondary">
            <option value="">Todos los equipos</option>
            @foreach($teams as $team)
                <option value="{{ $team->id }}" {{ request('team') == $team->id ? 'selected' : '' }}>
                    {{ $team->full_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="position" class="form-select bg-dark text-white border-secondary">
            <option value="">Posición</option>
            <option value="PG" {{ request('position') == 'PG' ? 'selected' : '' }}>PG</option>
            <option value="SG" {{ request('position') == 'SG' ? 'selected' : '' }}>SG</option>
            <option value="SF" {{ request('position') == 'SF' ? 'selected' : '' }}>SF</option>
            <option value="PF" {{ request('position') == 'PF' ? 'selected' : '' }}>PF</option>
            <option value="C"  {{ request('position') == 'C'  ? 'selected' : '' }}>C</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-nba w-100">
            <i class="bi bi-search"></i> Buscar
        </button>
    </div>
    @if(request('search') || request('team') || request('position'))
    <div class="col-md-1">
        <a href="{{ route('players.index') }}" class="btn btn-outline-secondary w-100">
            <i class="bi bi-x-circle"></i>
        </a>
    </div>
    @endif
</form>

{{-- Tabla de jugadores --}}
@if($players->count() > 0)
<div class="table-responsive">
    <table class="table table-dark table-hover align-middle">
        <thead class="text-warning">
    <tr>
        <th>#</th>
        <th>Jugador</th>
        <th>Equipo</th>
        <th>Pos</th>
        <th class="text-center"
            data-bs-toggle="tooltip"
            title="Puntos por partido">PTS</th>
        <th class="text-center"
            data-bs-toggle="tooltip"
            title="Rebotes por partido">REB</th>
        <th class="text-center"
            data-bs-toggle="tooltip"
            title="Asistencias por partido">AST</th>
        <th class="text-center"
            data-bs-toggle="tooltip"
            title="Robos por partido">STL</th>
        <th class="text-center"
            data-bs-toggle="tooltip"
            title="Tapones por partido">BLK</th>
        <th class="text-center"
            data-bs-toggle="tooltip"
            title="Porcentaje de tiros de campo">FG%</th>
        <th class="text-center">Estado</th>
    </tr>
</thead>
        <tbody>
            @foreach($players as $i => $player)
            <tr>
                <td class="text-secondary">{{ $i + 1 }}</td>
                <td>
                    <a href="{{ route('players.show', $player) }}"
                       class="text-white text-decoration-none fw-bold">
                        {{ $player->full_name }}
                    </a>
                </td>
                <td>
                    @if($player->team)
                        <a href="{{ route('teams.show', $player->team) }}"
                           class="text-decoration-none">
                            <span class="badge bg-secondary">{{ $player->team->abbreviation }}</span>
                        </a>
                    @else
                        <span class="text-secondary">-</span>
                    @endif
                </td>
                <td><span class="badge bg-dark border border-secondary">{{ $player->position ?? '-' }}</span></td>
                <td class="text-center text-warning fw-bold">{{ $player->currentStats?->pts ?? '-' }}</td>
                <td class="text-center">{{ $player->currentStats?->reb ?? '-' }}</td>
                <td class="text-center">{{ $player->currentStats?->ast ?? '-' }}</td>
                <td class="text-center">{{ $player->currentStats?->stl ?? '-' }}</td>
                <td class="text-center">{{ $player->currentStats?->blk ?? '-' }}</td>
                <td class="text-center">
                    {{ $player->currentStats ? number_format($player->currentStats->fg_pct * 100, 1) . '%' : '-' }}
                </td>
                <td class="text-center">
                    @if($player->activeInjury)
                        {!! $player->activeInjury->status_badge !!}
                    @else
                        <span class="badge bg-success">Sano</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-search fs-1 text-secondary"></i>
    <p class="text-secondary mt-3">No se encontraron jugadores.</p>
    <a href="{{ route('players.index') }}" class="btn btn-outline-warning">Ver todos</a>
</div>
@endif
@endsection