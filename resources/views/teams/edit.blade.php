@extends('layouts.app')

@section('title', 'Editar ' . $team->full_name . ' - NBA Simulator')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('teams.show', $team) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 class="text-warning fw-bold mb-0">
        <i class="bi bi-pencil-fill me-2"></i>Editar equipo
    </h2>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card p-4 mb-4 text-center">
            <img src="{{ $team->logo_url }}"
                 style="width:100px;height:100px;object-fit:contain;margin:0 auto;">
            <h3 class="text-warning fw-bold mt-3">{{ $team->full_name }}</h3>
            <span class="badge bg-warning text-dark">{{ $team->abbreviation }}</span>
        </div>

        <div class="card p-4">
            <form method="POST" action="{{ route('teams.update', $team) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-secondary small">Ciudad *</label>
                        <input type="text" name="city"
                               class="form-control bg-dark text-white border-secondary @error('city') is-invalid @enderror"
                               value="{{ old('city', $team->city) }}" required>
                        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small">Nombre *</label>
                        <input type="text" name="name"
                               class="form-control bg-dark text-white border-secondary @error('name') is-invalid @enderror"
                               value="{{ old('name', $team->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-secondary small">Nombre completo *</label>
                        <input type="text" name="full_name"
                               class="form-control bg-dark text-white border-secondary @error('full_name') is-invalid @enderror"
                               value="{{ old('full_name', $team->full_name) }}" required>
                        @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small">Conferencia *</label>
                        <select name="conference"
                                class="form-select bg-dark text-white border-secondary @error('conference') is-invalid @enderror"
                                required>
                            <option value="East" {{ old('conference', $team->conference) == 'East' ? 'selected' : '' }}>
                                Este (East)
                            </option>
                            <option value="West" {{ old('conference', $team->conference) == 'West' ? 'selected' : '' }}>
                                Oeste (West)
                            </option>
                        </select>
                        @error('conference') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small">División *</label>
                        <select name="division"
                                class="form-select bg-dark text-white border-secondary @error('division') is-invalid @enderror"
                                required>
                            @foreach(['Atlantic', 'Central', 'Southeast', 'Northwest', 'Pacific', 'Southwest'] as $div)
                                <option value="{{ $div }}"
                                    {{ old('division', $team->division) == $div ? 'selected' : '' }}>
                                    {{ $div }}
                                </option>
                            @endforeach
                        </select>
                        @error('division') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-nba btn-lg">
                        <i class="bi bi-check-circle-fill me-2"></i>Guardar cambios
                    </button>
                    <a href="{{ route('teams.show', $team) }}"
                       class="btn btn-outline-secondary btn-lg">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection