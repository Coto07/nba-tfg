@extends('layouts.app')

@section('title', 'Equipos - NBA Simulator')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-warning fw-bold mb-0">
        <i class="bi bi-shield-fill me-2"></i>Equipos NBA
    </h2>
    <span class="badge bg-secondary fs-6">{{ $teams->count() }} equipos</span>
</div>

{{-- Filtros --}}
<form method="GET" action="{{ route('teams.index') }}" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" name="search" class="form-control bg-dark text-white border-secondary"
               placeholder="Buscar equipo..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select name="conference" class="form-select bg-dark text-white border-secondary">
            <option value="">Todas las conferencias</option>
            <option value="East" {{ request('conference') == 'East' ? 'selected' : '' }}>Este</option>
            <option value="West" {{ request('conference') == 'West' ? 'selected' : '' }}>Oeste</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-nba w-100">
            <i class="bi bi-search"></i> Buscar
        </button>
    </div>
    @if(request('search') || request('conference'))
    <div class="col-md-2">
        <a href="{{ route('teams.index') }}" class="btn btn-outline-secondary w-100">
            <i class="bi bi-x-circle"></i> Limpiar
        </a>
    </div>
    @endif
</form>

{{-- Conferencia Este --}}
@php
    $east = $teams->filter(fn($t) => trim($t->conference) === 'East');
    $west = $teams->filter(fn($t) => trim($t->conference) === 'West');
@endphp

@if($east->count() > 0)
<h5 class="text-secondary mb-3"><i class="bi bi-geo-alt-fill text-warning"></i> Conferencia Este</h5>
<div class="row g-3 mb-4">
    @foreach($east as $team)
    <div class="col-6 col-md-4 col-lg-3">
        <a href="{{ route('teams.show', $team) }}" class="text-decoration-none">
            <div class="card h-100 text-center p-3 team-card">
                <div class="card-body p-2">
                    <div class="display-4 mb-2">🏀</div>
                    <h6 class="card-title mb-1">{{ $team->full_name }}</h6>
                    <span class="badge bg-warning text-dark">{{ $team->abbreviation }}</span>
                    <p class="text-secondary small mt-2 mb-0">{{ $team->division }}</p>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
@endif

@if($west->count() > 0)
<h5 class="text-secondary mb-3"><i class="bi bi-geo-alt-fill text-warning"></i> Conferencia Oeste</h5>
<div class="row g-3">
    @foreach($west as $team)
    <div class="col-6 col-md-4 col-lg-3">
        <a href="{{ route('teams.show', $team) }}" class="text-decoration-none">
            <div class="card h-100 text-center p-3 team-card">
                <div class="card-body p-2">
                    <div class="display-4 mb-2">🏀</div>
                    <h6 class="card-title mb-1">{{ $team->full_name }}</h6>
                    <span class="badge bg-warning text-dark">{{ $team->abbreviation }}</span>
                    <p class="text-secondary small mt-2 mb-0">{{ $team->division }}</p>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
@endif

@if($teams->count() === 0)
<div class="text-center py-5">
    <i class="bi bi-search fs-1 text-secondary"></i>
    <p class="text-secondary mt-3">No se encontraron equipos.</p>
    <a href="{{ route('teams.index') }}" class="btn btn-outline-warning">Ver todos</a>
</div>
@endif
@endsection

@section('styles')
<style>
    .team-card {
        transition: transform 0.2s, border-color 0.2s;
        cursor: pointer;
    }
    .team-card:hover {
        transform: translateY(-4px);
        border-color: #f8c200 !important;
    }
</style>
@endsection