@extends('layouts.app')

@section('title', 'Nuevo Jugador - NBA Simulator')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('players.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 class="text-warning fw-bold mb-0">
        <i class="bi bi-person-plus-fill me-2"></i>Nuevo Jugador
    </h2>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('players.store') }}">
            @csrf

            {{-- Datos personales --}}
            <div class="card p-4 mb-4">
                <h5 class="text-warning mb-3">
                    <i class="bi bi-person-fill me-2"></i>Datos personales
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-secondary small">Nombre *</label>
                        <input type="text" name="first_name"
                               class="form-control bg-dark text-white border-secondary @error('first_name') is-invalid @enderror"
                               value="{{ old('first_name') }}" required>
                        @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small">Apellido *</label>
                        <input type="text" name="last_name"
                               class="form-control bg-dark text-white border-secondary @error('last_name') is-invalid @enderror"
                               value="{{ old('last_name') }}" required>
                        @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small">Equipo *</label>
                        <select name="team_id"
                                class="form-select bg-dark text-white border-secondary @error('team_id') is-invalid @enderror"
                                required>
                            <option value="">Selecciona equipo...</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                    {{ $team->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('team_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small">Posición *</label>
                        <select name="position"
                                class="form-select bg-dark text-white border-secondary @error('position') is-invalid @enderror"
                                required>
                            <option value="">Selecciona posición...</option>
                            @foreach(['PG' => 'Base (PG)', 'SG' => 'Escolta (SG)', 'SF' => 'Alero (SF)', 'PF' => 'Ala-Pívot (PF)', 'C' => 'Pívot (C)'] as $val => $label)
                                <option value="{{ $val }}" {{ old('position') == $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Altura</label>
                        <input type="text" name="height"
                               class="form-control bg-dark text-white border-secondary"
                               placeholder="6'6&quot;" value="{{ old('height') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Peso (lbs)</label>
                        <input type="text" name="weight"
                               class="form-control bg-dark text-white border-secondary"
                               placeholder="220" value="{{ old('weight') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Universidad</label>
                        <input type="text" name="college"
                               class="form-control bg-dark text-white border-secondary"
                               value="{{ old('college') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">País</label>
                        <input type="text" name="country"
                               class="form-control bg-dark text-white border-secondary"
                               value="{{ old('country') }}">
                    </div>
                </div>
            </div>

            {{-- Estadísticas --}}
            <div class="card p-4 mb-4">
                <h5 class="text-warning mb-3">
                    <i class="bi bi-bar-chart-fill me-2"></i>Estadísticas temporada 2023-24
                </h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Partidos jugados *</label>
                        <input type="number" name="games_played" step="1" min="0" max="82"
                               class="form-control bg-dark text-white border-secondary @error('games_played') is-invalid @enderror"
                               value="{{ old('games_played') }}" required>
                        @error('games_played') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Minutos *</label>
                        <input type="number" name="min" step="0.1" min="0" max="48"
                               class="form-control bg-dark text-white border-secondary @error('min') is-invalid @enderror"
                               value="{{ old('min') }}" required>
                        @error('min') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Puntos (PTS) *</label>
                        <input type="number" name="pts" step="0.1" min="0" max="50"
                               class="form-control bg-dark text-white border-secondary @error('pts') is-invalid @enderror"
                               value="{{ old('pts') }}" required>
                        @error('pts') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Rebotes (REB) *</label>
                        <input type="number" name="reb" step="0.1" min="0" max="30"
                               class="form-control bg-dark text-white border-secondary @error('reb') is-invalid @enderror"
                               value="{{ old('reb') }}" required>
                        @error('reb') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Asistencias (AST) *</label>
                        <input type="number" name="ast" step="0.1" min="0" max="30"
                               class="form-control bg-dark text-white border-secondary @error('ast') is-invalid @enderror"
                               value="{{ old('ast') }}" required>
                        @error('ast') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Robos (STL) *</label>
                        <input type="number" name="stl" step="0.1" min="0" max="10"
                               class="form-control bg-dark text-white border-secondary @error('stl') is-invalid @enderror"
                               value="{{ old('stl') }}" required>
                        @error('stl') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Tapones (BLK) *</label>
                        <input type="number" name="blk" step="0.1" min="0" max="10"
                               class="form-control bg-dark text-white border-secondary @error('blk') is-invalid @enderror"
                               value="{{ old('blk') }}" required>
                        @error('blk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Pérdidas (TO)</label>
                        <input type="number" name="turnover" step="0.1" min="0" max="10"
                               class="form-control bg-dark text-white border-secondary"
                               value="{{ old('turnover', 0) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small">FG% (0.000 - 1.000) *</label>
                        <input type="number" name="fg_pct" step="0.001" min="0" max="1"
                               class="form-control bg-dark text-white border-secondary @error('fg_pct') is-invalid @enderror"
                               placeholder="0.450" value="{{ old('fg_pct') }}" required>
                        @error('fg_pct') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small">3P% (0.000 - 1.000) *</label>
                        <input type="number" name="fg3_pct" step="0.001" min="0" max="1"
                               class="form-control bg-dark text-white border-secondary @error('fg3_pct') is-invalid @enderror"
                               placeholder="0.350" value="{{ old('fg3_pct') }}" required>
                        @error('fg3_pct') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small">FT% (0.000 - 1.000) *</label>
                        <input type="number" name="ft_pct" step="0.001" min="0" max="1"
                               class="form-control bg-dark text-white border-secondary @error('ft_pct') is-invalid @enderror"
                               placeholder="0.800" value="{{ old('ft_pct') }}" required>
                        @error('ft_pct') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-nba btn-lg">
                    <i class="bi bi-check-circle-fill me-2"></i>Crear jugador
                </button>
                <a href="{{ route('players.index') }}" class="btn btn-outline-secondary btn-lg">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection