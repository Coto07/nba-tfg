@extends('layouts.app')

@section('title', 'Historial de Simulaciones - NBA Simulator')

@section('styles')
<style>
    .sim-card {
        background: #1a1a2e;
        border: 1px solid #2a2a4a;
        border-radius: 12px;
        transition: border-color 0.2s;
    }
    .sim-card:hover {
        border-color: #f8c200;
    }
    .score-display {
        font-size: 1.8rem;
        font-weight: bold;
        color: #f8c200;
    }
    .winner-team {
        filter: drop-shadow(0 0 8px #f8c200);
    }
    .stat-box {
        background: #0d0d0d;
        border-radius: 8px;
        padding: 16px;
        text-align: center;
    }
</style>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-warning fw-bold mb-0">
        <i class="bi bi-clock-history me-2"></i>Historial de Simulaciones
    </h2>
    <span class="badge bg-secondary fs-6">{{ $totalSims }} simulaciones</span>
</div>

@if($totalSims > 0)

{{-- ESTADÍSTICAS GLOBALES --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-box">
            <div class="fs-2 fw-bold text-warning">{{ $totalSims }}</div>
            <div class="text-secondary small">Total simulaciones</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box">
            <div class="fs-2 fw-bold text-warning">{{ $avgHomeScore }}</div>
            <div class="text-secondary small">Media puntos local</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box">
            <div class="fs-2 fw-bold text-info">{{ $avgAwayScore }}</div>
            <div class="text-secondary small">Media puntos visitante</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box">
            <div class="fs-2 fw-bold text-success">
                {{ $topTeams[0]['team']->abbreviation ?? '-' }}
            </div>
            <div class="text-secondary small">Equipo más victorioso</div>
        </div>
    </div>
</div>

{{-- TOP EQUIPOS --}}
@if(count($topTeams) > 0)
<div class="card p-4 mb-4">
    <h5 class="text-warning mb-3">
        <i class="bi bi-trophy-fill me-2"></i>Equipos con más victorias simuladas
    </h5>
    <div class="row g-3">
        @foreach($topTeams as $i => $item)
        <div class="col-md-2 col-4 text-center">
            <img src="{{ $item['team']->logo_url }}"
                 style="width:50px;height:50px;object-fit:contain;"
                 class="{{ $i === 0 ? 'winner-team' : '' }}">
            <div class="text-white small fw-bold mt-1">{{ $item['team']->abbreviation }}</div>
            <div class="text-warning fw-bold">{{ $item['wins'] }}V</div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- LISTA DE SIMULACIONES --}}
<div class="row g-3">
    @foreach($simulations as $sim)
    <div class="col-12">
        <div class="sim-card p-3">
            <div class="row align-items-center">

                {{-- Equipo local --}}
                <div class="col-4 text-center">
                    <img src="{{ $sim->homeTeam->logo_url }}"
                         style="width:50px;height:50px;object-fit:contain;"
                         class="{{ $sim->home_win_probability >= $sim->away_win_probability ? 'winner-team' : 'opacity-50' }}">
                    <div class="text-white small fw-bold mt-1">
                        {{ $sim->homeTeam->full_name }}
                    </div>
                    <span class="badge bg-warning text-dark">LOCAL</span>
                </div>

                {{-- Marcador --}}
                <div class="col-4 text-center">
                    <div class="score-display">
                        {{ $sim->home_score }} — {{ $sim->away_score }}
                    </div>
                    <div class="text-secondary small mt-1">
                        {{ $sim->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="mt-1">
                        <small class="text-secondary">
                            {{ $sim->home_win_probability }}% —
                            {{ $sim->away_win_probability }}%
                        </small>
                    </div>
                    {{-- Barra probabilidades --}}
                    <div class="progress mt-2" style="height:6px;">
                        <div class="progress-bar bg-warning"
                             style="width:{{ $sim->home_win_probability }}%"></div>
                        <div class="progress-bar bg-info"
                             style="width:{{ $sim->away_win_probability }}%"></div>
                    </div>
                </div>

                {{-- Equipo visitante --}}
                <div class="col-3 text-center">
                    <img src="{{ $sim->awayTeam->logo_url }}"
                         style="width:50px;height:50px;object-fit:contain;"
                         class="{{ $sim->away_win_probability > $sim->home_win_probability ? 'winner-team' : 'opacity-50' }}">
                    <div class="text-white small fw-bold mt-1">
                        {{ $sim->awayTeam->full_name }}
                    </div>
                    <span class="badge bg-info text-dark">VISITANTE</span>
                </div>

                {{-- Eliminar --}}
                <div class="col-1 text-center">
                    <form method="POST"
                          action="{{ route('simulations.destroy', $sim) }}"
                          onsubmit="return confirm('¿Eliminar esta simulación?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- PAGINACIÓN --}}
<div class="d-flex justify-content-center mt-4">
    {{ $simulations->links('pagination::bootstrap-5') }}
</div>

@else
<div class="text-center py-5">
    <i class="bi bi-clock-history fs-1 text-secondary"></i>
    <h4 class="text-secondary mt-3">No hay simulaciones todavía</h4>
    <a href="{{ route('simulator.index') }}" class="btn btn-nba mt-3">
        <i class="bi bi-play-fill me-2"></i>Simular un partido
    </a>
</div>
@endif

@endsection