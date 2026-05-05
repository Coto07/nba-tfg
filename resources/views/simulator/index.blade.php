@extends('layouts.app')

@section('title', 'Simulador - NBA Simulator')

@section('content')

<div class="text-center mb-5">
    <h2 class="text-warning fw-bold">
        <i class="bi bi-trophy-fill me-2"></i>Simulador de Partidos
    </h2>
    <p class="text-secondary">Selecciona dos equipos y simula el resultado basado en estadísticas reales.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card p-4 mb-5">
            <form method="POST" action="{{ route('simulator.simulate') }}">
                @csrf

                @error('home_team_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @error('away_team_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="row align-items-center g-3">
                    {{-- Equipo local --}}
                    <div class="col-md-5">
                        <label class="form-label text-warning fw-bold text-center d-block">
                            <i class="bi bi-house-fill me-1"></i> Equipo Local
                        </label>
                        <select name="home_team_id"
                                class="form-select bg-dark text-white border-warning text-center"
                                required>
                            <option value="">Selecciona equipo...</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}"
                                    {{ old('home_team_id') == $team->id ? 'selected' : '' }}>
                                    {{ $team->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- VS --}}
                    <div class="col-md-2 text-center">
                        <span class="display-6 fw-bold text-warning">VS</span>
                    </div>

                    {{-- Equipo visitante --}}
                    <div class="col-md-5">
                        <label class="form-label text-info fw-bold text-center d-block">
                            <i class="bi bi-airplane-fill me-1"></i> Equipo Visitante
                        </label>
                        <select name="away_team_id"
                                class="form-select bg-dark text-white border-info text-center"
                                required>
                            <option value="">Selecciona equipo...</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}"
                                    {{ old('away_team_id') == $team->id ? 'selected' : '' }}>
                                    {{ $team->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-nba btn-lg px-5">
                        <i class="bi bi-play-fill me-2"></i>Simular Partido
                    </button>
                </div>
            </form>
        </div>

        {{-- Simulaciones recientes --}}
        @if($recentSimulations->count() > 0)
        <h5 class="text-warning mb-3">
            <i class="bi bi-clock-history me-2"></i>Simulaciones recientes
        </h5>
        @foreach($recentSimulations as $sim)
        <div class="card mb-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold text-white">{{ $sim->homeTeam->abbreviation }}</span>
                    <span class="text-warning fw-bold fs-5">
                        {{ $sim->home_score }} - {{ $sim->away_score }}
                    </span>
                    <span class="fw-bold text-white">{{ $sim->awayTeam->abbreviation }}</span>
                </div>
                <div class="text-end">
                    <div class="small text-secondary">
                        Local: {{ $sim->home_win_probability }}% |
                        Visitante: {{ $sim->away_win_probability }}%
                    </div>
                    <div class="small text-secondary">
                        {{ $sim->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection