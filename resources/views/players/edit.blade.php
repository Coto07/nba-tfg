@extends('layouts.app')

@section('title', 'Editar ' . $player->full_name . ' - NBA Simulator')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('players.show', $player) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 class="text-warning fw-bold mb-0">
        <i class="bi bi-pencil-fill me-2"></i>Editar jugador
    </h2>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('players.update', $player) }}">
            @csrf
            @method('PUT')

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
                               value="{{ old('first_name', $player->first_name) }}" required>
                        @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small">Apellido *</label>
                        <input type="text" name="last_name"
                               class="form-control bg-dark text-white border-secondary @error('last_name') is-invalid @enderror"
                               value="{{ old('last_name', $player->last_name) }}" required>
                        @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small">Equipo *</label>
                        <select name="team_id"
                                class="form-select bg-dark text-white border-secondary @error('team_id') is-invalid @enderror"
                                required>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}"
                                    {{ old('team_id', $player->team_id) == $team->id ? 'selected' : '' }}>
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
                            @foreach(['PG' => 'Base (PG)', 'SG' => 'Escolta (SG)', 'SF' => 'Alero (SF)', 'PF' => 'Ala-Pívot (PF)', 'C' => 'Pívot (C)'] as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('position', $player->position) == $val ? 'selected' : '' }}>
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
                               value="{{ old('height', $player->height) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Peso (lbs)</label>
                        <input type="text" name="weight"
                               class="form-control bg-dark text-white border-secondary"
                               value="{{ old('weight', $player->weight) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Universidad</label>
                        <input type="text" name="college"
                               class="form-control bg-dark text-white border-secondary"
                               value="{{ old('college', $player->college) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">País</label>
                        <input type="text" name="country"
                               class="form-control bg-dark text-white border-secondary"
                               value="{{ old('country', $player->country) }}">
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
                               value="{{ old('games_played', $stats?->games_played) }}" required>
                        @error('games_played') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Minutos *</label>
                        <input type="number" name="min" step="0.1" min="0" max="48"
                               class="form-control bg-dark text-white border-secondary @error('min') is-invalid @enderror"
                               value="{{ old('min', $stats?->min) }}" required>
                        @error('min') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Puntos (PTS) *</label>
                        <input type="number" name="pts" step="0.1" min="0" max="50"
                               class="form-control bg-dark text-white border-secondary @error('pts') is-invalid @enderror"
                               value="{{ old('pts', $stats?->pts) }}" required>
                        @error('pts') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Rebotes (REB) *</label>
                        <input type="number" name="reb" step="0.1" min="0" max="30"
                               class="form-control bg-dark text-white border-secondary @error('reb') is-invalid @enderror"
                               value="{{ old('reb', $stats?->reb) }}" required>
                        @error('reb') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Asistencias (AST) *</label>
                        <input type="number" name="ast" step="0.1" min="0" max="30"
                               class="form-control bg-dark text-white border-secondary @error('ast') is-invalid @enderror"
                               value="{{ old('ast', $stats?->ast) }}" required>
                        @error('ast') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Robos (STL) *</label>
                        <input type="number" name="stl" step="0.1" min="0" max="10"
                               class="form-control bg-dark text-white border-secondary @error('stl') is-invalid @enderror"
                               value="{{ old('stl', $stats?->stl) }}" required>
                        @error('stl') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Tapones (BLK) *</label>
                        <input type="number" name="blk" step="0.1" min="0" max="10"
                               class="form-control bg-dark text-white border-secondary @error('blk') is-invalid @enderror"
                               value="{{ old('blk', $stats?->blk) }}" required>
                        @error('blk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-secondary small">Pérdidas (TO)</label>
                        <input type="number" name="turnover" step="0.1" min="0" max="10"
                               class="form-control bg-dark text-white border-secondary"
                               value="{{ old('turnover', $stats?->turnover) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small">FG% (0.000 - 1.000) *</label>
                        <input type="number" name="fg_pct" step="0.001" min="0" max="1"
                               class="form-control bg-dark text-white border-secondary @error('fg_pct') is-invalid @enderror"
                               value="{{ old('fg_pct', $stats?->fg_pct) }}" required>
                        @error('fg_pct') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small">3P% (0.000 - 1.000) *</label>
                        <input type="number" name="fg3_pct" step="0.001" min="0" max="1"
                               class="form-control bg-dark text-white border-secondary @error('fg3_pct') is-invalid @enderror"
                               value="{{ old('fg3_pct', $stats?->fg3_pct) }}" required>
                        @error('fg3_pct') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small">FT% (0.000 - 1.000) *</label>
                        <input type="number" name="ft_pct" step="0.001" min="0" max="1"
                               class="form-control bg-dark text-white border-secondary @error('ft_pct') is-invalid @enderror"
                               value="{{ old('ft_pct', $stats?->ft_pct) }}" required>
                        @error('ft_pct') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-nba btn-lg">
                    <i class="bi bi-check-circle-fill me-2"></i>Guardar cambios
                </button>
                <a href="{{ route('players.show', $player) }}"
                   class="btn btn-outline-secondary btn-lg">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection