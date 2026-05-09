@extends('layouts.app')

@section('title', 'Lesiones - NBA Simulator')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-warning fw-bold mb-0">
        <i class="bi bi-bandaid-fill me-2"></i>Gestión de Lesiones
    </h2>
    <span class="badge bg-danger fs-6">{{ $injuries->count() }} lesiones activas</span>
</div>

<div class="row g-4">

    {{-- Formulario para añadir lesión --}}
    <div class="col-lg-4">
        <div class="card p-4">
            <h5 class="text-warning mb-3">
                <i class="bi bi-plus-circle-fill me-2"></i>Registrar lesión
            </h5>
            <form method="POST" action="{{ route('injuries.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-secondary small">Jugador</label>
                    <select name="player_id" class="form-select bg-dark text-white border-secondary" required>
                        <option value="">Selecciona jugador...</option>
                        @foreach($players as $player)
                            <option value="{{ $player->id }}"
                                {{ old('player_id') == $player->id ? 'selected' : '' }}>
                                {{ $player->full_name }}
                                @if($player->team) ({{ $player->team->abbreviation }}) @endif
                            </option>
                        @endforeach
                    </select>
                    @error('player_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small">Descripción</label>
                    <input type="text" name="description"
                           class="form-control bg-dark text-white border-secondary"
                           placeholder="Ej: Esguince tobillo derecho"
                           value="{{ old('description') }}" required>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small">Estado</label>
                    <select name="status" class="form-select bg-dark text-white border-secondary" required>
                        <option value="out" {{ old('status') == 'out' ? 'selected' : '' }}>
                            🔴 Baja
                        </option>
                        <option value="questionable" {{ old('status') == 'questionable' ? 'selected' : '' }}>
                            🟡 Dudoso
                        </option>
                        <option value="day-to-day" {{ old('status') == 'day-to-day' ? 'selected' : '' }}>
                            🔵 Día a día
                        </option>
                    </select>
                    @error('status')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small">Fecha de lesión</label>
                    <input type="date" name="injured_at"
                           class="form-control bg-dark text-white border-secondary"
                           value="{{ old('injured_at', date('Y-m-d')) }}" required>
                    @error('injured_at')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small">Regreso estimado (opcional)</label>
                    <input type="date" name="expected_return"
                           class="form-control bg-dark text-white border-secondary"
                           value="{{ old('expected_return') }}">
                    @error('expected_return')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-nba w-100">
                    <i class="bi bi-plus-circle-fill me-2"></i>Registrar lesión
                </button>
            </form>
        </div>
    </div>

    {{-- Lista de lesiones activas --}}
    <div class="col-lg-8">
        <h5 class="text-warning mb-3">
            <i class="bi bi-list-ul me-2"></i>Lesiones activas
        </h5>

        @if($injuries->count() > 0)
            @foreach($injuries as $injury)
            <div class="card mb-3 p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex gap-3 align-items-center">
                        <div style="width:48px;height:48px;background:#f8c200;border-radius:50%;
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:1.2rem;font-weight:bold;color:#000;">
                            {{ strtoupper(substr($injury->player->first_name, 0, 1)) }}
                        </div>
                        <div>
                            <a href="{{ route('players.show', $injury->player) }}"
                               class="text-white text-decoration-none fw-bold">
                                {{ $injury->player->full_name }}
                            </a>
                            @if($injury->player->team)
                                <span class="badge bg-secondary ms-2">
                                    {{ $injury->player->team->abbreviation }}
                                </span>
                            @endif
                            <p class="text-secondary small mb-1 mt-1">
                                <i class="bi bi-chat-left-text-fill me-1"></i>{{ $injury->description }}
                            </p>
                            <div class="d-flex gap-2 flex-wrap">
                                {!! $injury->status_badge !!}
                                <span class="text-secondary small">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    Desde: {{ $injury->injured_at->format('d/m/Y') }}
                                </span>
                                @if($injury->expected_return)
                                <span class="text-secondary small">
                                    <i class="bi bi-calendar-check me-1"></i>
                                    Regreso: {{ $injury->expected_return->format('d/m/Y') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Botones editar y recuperado --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('injuries.edit', $injury) }}"
                           class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-pencil-fill me-1"></i>Editar
                        </a>
                        <form method="POST"
                              action="{{ route('injuries.destroy', $injury) }}"
                              onsubmit="return confirm('¿Marcar como recuperado?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-check-circle-fill me-1"></i>Recuperado
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="card p-5 text-center">
                <i class="bi bi-emoji-smile fs-1 text-success"></i>
                <p class="text-secondary mt-3 mb-0">No hay lesiones activas registradas.</p>
            </div>
        @endif
    </div>
</div>
@endsection