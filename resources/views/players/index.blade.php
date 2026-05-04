@extends('layouts.app')

@section('title', 'Jugadores - NBA Simulator')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-warning fw-bold mb-0">
        <i class="bi bi-person-fill me-2"></i>Jugadores NBA
    </h2>
    <span class="badge bg-secondary fs-6">{{ $players->count() }} jugadores</span>
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
                <th class="text-center">PTS</th>
                <th class="text-center">REB</th>
                <th class="text-center">AST</th>
                <th class="text-center">STL</th>
                <th class="text-center">BLK</th>
                <th class="text-center">FG%</th>
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