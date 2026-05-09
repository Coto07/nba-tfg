@extends('layouts.app')

@section('title', 'Editar Lesión - NBA Simulator')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('injuries.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 class="text-warning fw-bold mb-0">
        <i class="bi bi-pencil-fill me-2"></i>Editar lesión
    </h2>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card p-4">
            <form method="POST" action="{{ route('injuries.update', $injury) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label text-secondary small">Jugador</label>
                    <select name="player_id"
                            class="form-select bg-dark text-white border-secondary"
                            required>
                        @foreach($players as $player)
                            <option value="{{ $player->id }}"
                                {{ $injury->player_id == $player->id ? 'selected' : '' }}>
                                {{ $player->full_name }}
                                @if($player->team) ({{ $player->team->abbreviation }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small">Descripción</label>
                    <input type="text" name="description"
                           class="form-control bg-dark text-white border-secondary @error('description') is-invalid @enderror"
                           value="{{ old('description', $injury->description) }}" required>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small">Estado</label>
                    <select name="status"
                            class="form-select bg-dark text-white border-secondary"
                            required>
                        <option value="out" {{ $injury->status == 'out' ? 'selected' : '' }}>
                            🔴 Baja
                        </option>
                        <option value="questionable" {{ $injury->status == 'questionable' ? 'selected' : '' }}>
                            🟡 Dudoso
                        </option>
                        <option value="day-to-day" {{ $injury->status == 'day-to-day' ? 'selected' : '' }}>
                            🔵 Día a día
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small">Fecha de lesión</label>
                    <input type="date" name="injured_at"
                           class="form-control bg-dark text-white border-secondary @error('injured_at') is-invalid @enderror"
                           value="{{ old('injured_at', $injury->injured_at->format('Y-m-d')) }}" required>
                    @error('injured_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small">Regreso estimado (opcional)</label>
                    <input type="date" name="expected_return"
                           class="form-control bg-dark text-white border-secondary"
                           value="{{ old('expected_return', $injury->expected_return?->format('Y-m-d')) }}">
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-nba btn-lg">
                        <i class="bi bi-check-circle-fill me-2"></i>Guardar cambios
                    </button>
                    <a href="{{ route('injuries.index') }}"
                       class="btn btn-outline-secondary btn-lg">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection