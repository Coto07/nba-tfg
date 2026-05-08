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
                    <div class="col-md-5 text-center">
                        <label class="form-label text-warning fw-bold d-block">
                            <i class="bi bi-house-fill me-1"></i> Equipo Local
                        </label>
                        <div style="height:80px;" class="d-flex align-items-center justify-content-center mb-2">
                            <img id="home-logo-img" src="" alt=""
                                 style="height:80px;object-fit:contain;display:none;">
                            <i id="home-placeholder" class="bi bi-shield fs-1 text-warning opacity-25"></i>
                        </div>
                        <select name="home_team_id"
                                id="home_team_id"
                                class="form-select bg-dark text-white border-warning text-center"
                                required>
                            <option value="">Selecciona equipo...</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}"
                                        data-logo="{{ $team->logo_url }}"
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
                    <div class="col-md-5 text-center">
                        <label class="form-label text-info fw-bold d-block">
                            <i class="bi bi-airplane-fill me-1"></i> Equipo Visitante
                        </label>
                        <div style="height:80px;" class="d-flex align-items-center justify-content-center mb-2">
                            <img id="away-logo-img" src="" alt=""
                                 style="height:80px;object-fit:contain;display:none;">
                            <i id="away-placeholder" class="bi bi-shield fs-1 text-info opacity-25"></i>
                        </div>
                        <select name="away_team_id"
                                id="away_team_id"
                                class="form-select bg-dark text-white border-info text-center"
                                required>
                            <option value="">Selecciona equipo...</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}"
                                        data-logo="{{ $team->logo_url }}"
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

        {{-- AVISO DE LESIONES EN EL SIMULADOR --}}
        @if(isset($globalInjuries) && $globalInjuries->count() > 0)
        <div class="card p-3 mb-4" style="border-left: 3px solid #dc3545;">
            <h6 class="text-danger mb-2">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Jugadores lesionados que afectan a la simulación
            </h6>
            <div class="row g-2">
                @foreach($globalInjuries as $injury)
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-2 p-2 rounded"
                         style="background:#0d0d0d;">
                        @if($injury->player->team)
                            <img src="{{ $injury->player->team->logo_url }}"
                                 style="width:24px;height:24px;object-fit:contain;">
                        @endif
                        <div class="flex-fill">
                            <div class="text-white small fw-bold">
                                {{ $injury->player->full_name }}
                            </div>
                            <div class="text-secondary" style="font-size:0.75rem;">
                                {{ $injury->description }}
                            </div>
                        </div>
                        {!! $injury->status_badge !!}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Simulaciones recientes --}}
        @if($recentSimulations->count() > 0)
        <h5 class="text-warning mb-3">
            <i class="bi bi-clock-history me-2"></i>Simulaciones recientes
        </h5>
        @foreach($recentSimulations as $sim)
        <div class="card mb-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ $sim->homeTeam->logo_url }}"
                         alt="{{ $sim->homeTeam->abbreviation }}"
                         style="width:32px;height:32px;object-fit:contain;">
                    <span class="text-warning fw-bold fs-5">
                        {{ $sim->home_score }} - {{ $sim->away_score }}
                    </span>
                    <img src="{{ $sim->awayTeam->logo_url }}"
                         alt="{{ $sim->awayTeam->abbreviation }}"
                         style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div class="text-end">
                    <div class="small text-white">
                        {{ $sim->homeTeam->abbreviation }} vs {{ $sim->awayTeam->abbreviation }}
                    </div>
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

@section('scripts')
<script>
    function updateLogo(selectId, imgId, placeholderId) {
        const select      = document.getElementById(selectId);
        const img         = document.getElementById(imgId);
        const placeholder = document.getElementById(placeholderId);
        const option      = select.options[select.selectedIndex];
        const logo        = option.getAttribute('data-logo');

        if (logo && select.value !== '') {
            img.src                   = logo;
            img.alt                   = option.text;
            img.style.display         = 'inline';
            placeholder.style.display = 'none';
        } else {
            img.style.display         = 'none';
            placeholder.style.display = 'inline';
        }
    }

    document.getElementById('home_team_id').addEventListener('change', function () {
        updateLogo('home_team_id', 'home-logo-img', 'home-placeholder');
    });

    document.getElementById('away_team_id').addEventListener('change', function () {
        updateLogo('away_team_id', 'away-logo-img', 'away-placeholder');
    });
</script>
@endsection