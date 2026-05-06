@extends('layouts.app')

@section('title', $team->full_name . ' - NBA Simulator')

@section('content')

{{-- Cabecera del equipo --}}
<div class="card mb-4 p-4">
    <div class="d-flex align-items-center gap-4">
        <img src="{{ $team->logo_url }}"
     alt="{{ $team->full_name }}"
     style="width:100px;height:100px;object-fit:contain;"
     onerror="this.src='https://a.espncdn.com/i/teamlogos/nba/500/nba.png'">
        <div>
            <h1 class="text-warning fw-bold mb-1">{{ $team->full_name }}</h1>
            <div class="d-flex gap-2 flex-wrap">
                <span class="badge bg-warning text-dark fs-6">{{ $team->abbreviation }}</span>
                <span class="badge bg-secondary">{{ $team->conference }}ern Conference</span>
                <span class="badge bg-secondary">{{ $team->division }} Division</span>
            </div>
        </div>
    </div>
</div>

{{-- Jugadores del equipo --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="text-warning mb-0">
        <i class="bi bi-people-fill me-2"></i>Plantilla
    </h4>
    <span class="badge bg-secondary">{{ $players->count() }} jugadores</span>
</div>

@if($players->count() > 0)
<div class="table-responsive">
    <table class="table table-dark table-hover align-middle">
        <thead class="text-warning">
            <tr>
                <th>Jugador</th>
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
            @foreach($players as $player)
            <tr>
                <td>
                    <a href="{{ route('players.show', $player) }}" class="text-white text-decoration-none fw-bold">
                        {{ $player->full_name }}
                    </a>
                </td>
                <td><span class="badge bg-secondary">{{ $player->position ?? '-' }}</span></td>
                <td class="text-center text-warning fw-bold">
                    {{ $player->currentStats?->pts ?? '-' }}
                </td>
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
<div class="text-center py-4">
    <p class="text-secondary">No hay jugadores registrados para este equipo.</p>
</div>
@endif

<a href="{{ route('teams.index') }}" class="btn btn-outline-warning mt-3">
    <i class="bi bi-arrow-left"></i> Volver a equipos
</a>
@endsection