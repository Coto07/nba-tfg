@extends('layouts.app')

@section('title', 'Rankings NBA - NBA Simulator')

@section('styles')
<style>
    .category-btn {
        background: #1a1a2e;
        border: 1px solid #2a2a4a;
        color: #aaa;
        border-radius: 8px;
        padding: 8px 16px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
        font-size: 0.85rem;
    }
    .category-btn:hover {
        border-color: #f8c200;
        color: #f8c200;
    }
    .category-btn.active {
        background: #f8c200;
        border-color: #f8c200;
        color: #000;
        font-weight: bold;
    }
    .rank-number {
        font-size: 1.5rem;
        font-weight: bold;
        min-width: 50px;
        text-align: center;
    }
    .rank-1 { color: #FFD700; }
    .rank-2 { color: #C0C0C0; }
    .rank-3 { color: #CD7F32; }
    .rank-other { color: #555; }
    .stat-highlight {
        font-size: 1.4rem;
        font-weight: bold;
        color: #f8c200;
        min-width: 70px;
        text-align: right;
    }
    .bar-fill {
        height: 6px;
        border-radius: 3px;
        background: linear-gradient(90deg, #f8c200, #ff8c00);
        transition: width 0.5s ease;
    }
    .player-row {
        transition: background 0.2s;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 4px;
    }
    .player-row:hover {
        background: #1a1a2e;
    }
</style>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-warning fw-bold mb-0">
        <i class="bi bi-list-ol me-2"></i>Rankings NBA
    </h2>
    <span class="badge bg-secondary fs-6">Top 25</span>
</div>

{{-- Categorías --}}
<div class="d-flex flex-wrap gap-2 mb-4">
    @foreach($categories as $key => $cat)
    <a href="{{ route('rankings.index', array_merge(request()->query(), ['category' => $key])) }}"
       class="category-btn {{ $category === $key ? 'active' : '' }}">
        {{ $cat['icon'] }} {{ $cat['label'] }}
    </a>
    @endforeach
</div>

{{-- Filtros --}}
<form method="GET" action="{{ route('rankings.index') }}" class="row g-2 mb-4">
    <input type="hidden" name="category" value="{{ $category }}">
    <div class="col-md-3">
        <select name="position" class="form-select bg-dark text-white border-secondary">
            <option value="">Todas las posiciones</option>
            @foreach(['PG', 'SG', 'SF', 'PF', 'C'] as $pos)
                <option value="{{ $pos }}" {{ $position === $pos ? 'selected' : '' }}>
                    {{ $pos }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="conference" class="form-select bg-dark text-white border-secondary">
            <option value="">Todas las conferencias</option>
            <option value="East" {{ $conference === 'East' ? 'selected' : '' }}>Este</option>
            <option value="West" {{ $conference === 'West' ? 'selected' : '' }}>Oeste</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-nba w-100">
            <i class="bi bi-funnel-fill"></i> Filtrar
        </button>
    </div>
    @if($position || $conference)
    <div class="col-md-2">
        <a href="{{ route('rankings.index', ['category' => $category]) }}"
           class="btn btn-outline-secondary w-100">
            <i class="bi bi-x-circle"></i> Limpiar
        </a>
    </div>
    @endif
</form>

{{-- Título del ranking actual --}}
<div class="card p-3 mb-4" style="border-left: 4px solid #f8c200;">
    <div class="d-flex align-items-center gap-3">
        <span class="fs-2">{{ $categories[$category]['icon'] }}</span>
        <div>
            <h5 class="text-warning mb-0">Top {{ $players->count() }} — {{ $categories[$category]['label'] }}</h5>
            <small class="text-secondary">Temporada 2023-24 · Mínimo 10 partidos jugados</small>
        </div>
    </div>
</div>

{{-- Lista de rankings --}}
@php
    $maxVal = $players->first()?->currentStats?->{$category} ?? 1;
    $isPercentage = in_array($category, ['fg_pct', 'fg3_pct', 'ft_pct']);
@endphp

@if($players->count() > 0)
<div class="card p-3">
    @foreach($players as $i => $player)
    @php
        $val = $player->currentStats?->{$category} ?? 0;
        $displayVal = $isPercentage ? number_format($val * 100, 1) . '%' : $val;
        $barWidth = $maxVal > 0 ? ($val / $maxVal) * 100 : 0;
        $rankClass = match($i) {
            0 => 'rank-1',
            1 => 'rank-2',
            2 => 'rank-3',
            default => 'rank-other'
        };
    @endphp
    <div class="player-row d-flex align-items-center gap-3">

        {{-- Número --}}
        <div class="rank-number {{ $rankClass }}">
            @if($i === 0) 🥇
            @elseif($i === 1) 🥈
            @elseif($i === 2) 🥉
            @else {{ $i + 1 }}
            @endif
        </div>

        {{-- Logo equipo --}}
        @if($player->team)
        <img src="{{ $player->team->logo_url }}"
             alt="{{ $player->team->abbreviation }}"
             style="width:36px;height:36px;object-fit:contain;">
        @endif

        {{-- Nombre y info --}}
        <div class="flex-fill">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('players.show', $player) }}"
                   class="text-white text-decoration-none fw-bold">
                    {{ $player->full_name }}
                </a>
                <span class="badge bg-secondary small">{{ $player->position ?? '?' }}</span>
                @if($player->team)
                    <span class="badge bg-dark border border-secondary small">
                        {{ $player->team->abbreviation }}
                    </span>
                @endif
                @if($player->activeInjury)
                    {!! $player->activeInjury->status_badge !!}
                @endif
            </div>
            <div class="mt-1" style="max-width: 300px;">
                <div class="bar-fill" style="width: {{ $barWidth }}%"></div>
            </div>
        </div>

        {{-- Valor --}}
        <div class="stat-highlight">{{ $displayVal }}</div>

        {{-- Botón comparar --}}
        <a href="{{ route('compare.index') }}?player1={{ $player->id }}"
           class="btn btn-outline-warning btn-sm d-none d-md-inline">
            <i class="bi bi-arrows-angle-expand"></i>
        </a>
    </div>

    @if($i < $players->count() - 1)
    <hr class="my-1" style="border-color: #2a2a4a;">
    @endif
    @endforeach
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-search fs-1 text-secondary"></i>
    <p class="text-secondary mt-3">No se encontraron jugadores con estos filtros.</p>
    <a href="{{ route('rankings.index') }}" class="btn btn-outline-warning">Ver todos</a>
</div>
@endif

@endsection