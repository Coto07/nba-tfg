@extends('layouts.app')

@section('title', $player1->full_name . ' vs ' . $player2->full_name . ' - NBA Simulator')

@section('styles')
<style>
    .compare-header {
        background: linear-gradient(135deg, #0a0a1a 0%, #1a1a2e 100%);
        border: 2px solid #2a2a4a;
        border-radius: 16px;
    }
    .avatar-lg {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        font-weight: bold;
        margin: 0 auto;
    }
    .stat-row {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #2a2a4a;
    }
    .stat-row:last-child {
        border-bottom: none;
    }
    .stat-value {
        font-size: 1.3rem;
        font-weight: bold;
        min-width: 60px;
        text-align: center;
    }
    .stat-label {
        flex: 1;
        text-align: center;
        color: #aaa;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .winner-stat {
        color: #f8c200;
    }
    .loser-stat {
        color: #6c757d;
    }
    .stat-bar-container {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .better-badge {
        font-size: 0.7rem;
        padding: 2px 6px;
    }
</style>
@endsection

@section('content')

{{-- CABECERA COMPARATIVA --}}
<div class="compare-header p-4 mb-4">
    <div class="row align-items-center">

        {{-- Jugador 1 --}}
        <div class="col-5 text-center">
            <div class="avatar-lg mb-3" style="background:#f8c200;color:#000;">
                {{ strtoupper(substr($player1->first_name, 0, 1)) }}
            </div>
            <h3 class="text-warning fw-bold mb-1">{{ $player1->full_name }}</h3>
            @if($player1->team)
                <a href="{{ route('teams.show', $player1->team) }}" class="text-decoration-none">
                    <img src="{{ $player1->team->logo_url }}"
                         style="width:30px;height:30px;object-fit:contain;" class="me-1">
                    <span class="badge bg-warning text-dark">{{ $player1->team->abbreviation }}</span>
                </a>
            @endif
            <div class="mt-2">
                <span class="badge bg-secondary">{{ $player1->position ?? 'N/A' }}</span>
                @if($player1->activeInjury)
                    {!! $player1->activeInjury->status_badge !!}
                @else
                    <span class="badge bg-success">Sano</span>
                @endif
            </div>
        </div>

        {{-- VS --}}
        <div class="col-2 text-center">
            <div style="background:#f8c200;color:#000;font-weight:bold;border-radius:50%;
                        width:50px;height:50px;display:flex;align-items:center;
                        justify-content:center;margin:0 auto;font-size:0.9rem;">
                VS
            </div>
        </div>

        {{-- Jugador 2 --}}
        <div class="col-5 text-center">
            <div class="avatar-lg mb-3" style="background:#0dcaf0;color:#000;">
                {{ strtoupper(substr($player2->first_name, 0, 1)) }}
            </div>
            <h3 class="text-info fw-bold mb-1">{{ $player2->full_name }}</h3>
            @if($player2->team)
                <a href="{{ route('teams.show', $player2->team) }}" class="text-decoration-none">
                    <img src="{{ $player2->team->logo_url }}"
                         style="width:30px;height:30px;object-fit:contain;" class="me-1">
                    <span class="badge bg-info text-dark">{{ $player2->team->abbreviation }}</span>
                </a>
            @endif
            <div class="mt-2">
                <span class="badge bg-secondary">{{ $player2->position ?? 'N/A' }}</span>
                @if($player2->activeInjury)
                    {!! $player2->activeInjury->status_badge !!}
                @else
                    <span class="badge bg-success">Sano</span>
                @endif
            </div>
        </div>
    </div>
</div>

@php
    $s1 = $player1->currentStats;
    $s2 = $player2->currentStats;
@endphp

@if($s1 && $s2)

{{-- ESTADÍSTICAS CARA A CARA --}}
<div class="card p-4 mb-4">
    <h5 class="text-warning mb-4 text-center">
        <i class="bi bi-bar-chart-fill me-2"></i>Estadísticas Temporada 2023-24
    </h5>

    @php
        $stats = [
            ['label' => 'Puntos por partido', 'key' => 'pts', 'icon' => '🏀'],
            ['label' => 'Rebotes por partido', 'key' => 'reb', 'icon' => '📊'],
            ['label' => 'Asistencias por partido', 'key' => 'ast', 'icon' => '🎯'],
            ['label' => 'Robos por partido', 'key' => 'stl', 'icon' => '✋'],
            ['label' => 'Tapones por partido', 'key' => 'blk', 'icon' => '🛡️'],
            ['label' => 'Minutos por partido', 'key' => 'min', 'icon' => '⏱️'],
            ['label' => 'Partidos jugados', 'key' => 'games_played', 'icon' => '📅'],
        ];
    @endphp

    @foreach($stats as $stat)
    @php
        $v1 = $s1->{$stat['key']};
        $v2 = $s2->{$stat['key']};
        $max = max($v1, $v2);
        $p1Width = $max > 0 ? ($v1 / $max) * 100 : 50;
        $p2Width = $max > 0 ? ($v2 / $max) * 100 : 50;
    @endphp
    <div class="stat-row">
        {{-- Valor jugador 1 --}}
        <div class="stat-value {{ $v1 > $v2 ? 'winner-stat' : ($v1 < $v2 ? 'loser-stat' : 'text-white') }}">
            {{ $v1 }}
            @if($v1 > $v2)
                <i class="bi bi-caret-up-fill text-warning small"></i>
            @endif
        </div>

        {{-- Barra y label --}}
        <div class="flex-fill mx-3">
            <div class="stat-label mb-2">{{ $stat['icon'] }} {{ $stat['label'] }}</div>
            <div class="d-flex align-items-center gap-2">
                {{-- Barra jugador 1 (izquierda) --}}
                <div class="flex-fill" style="height:8px;background:#2a2a4a;border-radius:4px;overflow:hidden;">
                    <div style="height:100%;width:{{ $p1Width }}%;background:#f8c200;
                                border-radius:4px;float:right;"></div>
                </div>
                {{-- Barra jugador 2 (derecha) --}}
                <div class="flex-fill" style="height:8px;background:#2a2a4a;border-radius:4px;overflow:hidden;">
                    <div style="height:100%;width:{{ $p2Width }}%;background:#0dcaf0;border-radius:4px;"></div>
                </div>
            </div>
        </div>

        {{-- Valor jugador 2 --}}
        <div class="stat-value {{ $v2 > $v1 ? 'winner-stat' : ($v2 < $v1 ? 'loser-stat' : 'text-white') }}">
            @if($v2 > $v1)
                <i class="bi bi-caret-up-fill text-warning small"></i>
            @endif
            {{ $v2 }}
        </div>
    </div>
    @endforeach
</div>

{{-- PORCENTAJES DE TIRO --}}
<div class="card p-4 mb-4">
    <h5 class="text-warning mb-4 text-center">
        <i class="bi bi-percent me-2"></i>Porcentajes de tiro
    </h5>

    @php
        $shooting = [
            ['label' => 'FG%', 'v1' => $s1->fg_pct * 100, 'v2' => $s2->fg_pct * 100],
            ['label' => '3P%', 'v1' => $s1->fg3_pct * 100, 'v2' => $s2->fg3_pct * 100],
            ['label' => 'FT%', 'v1' => $s1->ft_pct * 100, 'v2' => $s2->ft_pct * 100],
        ];
    @endphp

    <div class="row g-3">
        @foreach($shooting as $s)
        <div class="col-md-4">
            <div class="p-3 rounded" style="background:#0d0d0d;">
                <div class="text-center mb-2 text-secondary small">{{ $s['label'] }}</div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold {{ $s['v1'] > $s['v2'] ? 'text-warning' : 'text-secondary' }}">
                        {{ number_format($s['v1'], 1) }}%
                    </span>
                    <span class="text-secondary small">vs</span>
                    <span class="fw-bold {{ $s['v2'] > $s['v1'] ? 'text-info' : 'text-secondary' }}">
                        {{ number_format($s['v2'], 1) }}%
                    </span>
                </div>
                <div class="progress mt-2" style="height:6px;">
                    <div class="progress-bar bg-warning"
                         style="width:{{ $s['v1'] }}%"></div>
                </div>
                <div class="progress mt-1" style="height:6px;">
                    <div class="progress-bar bg-info"
                         style="width:{{ $s['v2'] }}%"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- GRÁFICA RADAR --}}
<div class="card p-4 mb-4">
    <h5 class="text-warning mb-3 text-center">
        <i class="bi bi-diagram-3-fill me-2"></i>Perfil comparativo
    </h5>
    <canvas id="radarChart" height="100"></canvas>
</div>

{{-- VEREDICTO --}}
@php
    $p1Score = $s1->pts + $s1->reb + $s1->ast + $s1->stl * 2 + $s1->blk * 2;
    $p2Score = $s2->pts + $s2->reb + $s2->ast + $s2->stl * 2 + $s2->blk * 2;
    $winner  = $p1Score >= $p2Score ? $player1 : $player2;
    $winnerScore = max($p1Score, $p2Score);
    $loserScore  = min($p1Score, $p2Score);
    $diff = round($winnerScore - $loserScore, 1);
@endphp

<div class="card p-4 mb-4 text-center"
     style="border: 2px solid #f8c200; background: linear-gradient(135deg, #0a0a1a, #1a1a2e);">
    <h5 class="text-warning mb-3">
        <i class="bi bi-trophy-fill me-2"></i>Veredicto
    </h5>
    <div class="avatar-lg mb-3 mx-auto"
         style="background:{{ $winner->id === $player1->id ? '#f8c200' : '#0dcaf0' }};color:#000;">
        {{ strtoupper(substr($winner->first_name, 0, 1)) }}
    </div>
    <h4 class="text-warning fw-bold">{{ $winner->full_name }}</h4>
    <p class="text-secondary mb-0">
        Mejor valoración global con <strong class="text-warning">{{ round($winnerScore, 1) }}</strong> puntos
        frente a <strong class="text-secondary">{{ round($loserScore, 1) }}</strong>
        (diferencia de <strong class="text-warning">+{{ $diff }}</strong>)
    </p>
    <p class="text-secondary small mt-2">
        * Basado en PTS + REB + AST + STL×2 + BLK×2
    </p>
</div>

@else
<div class="alert alert-warning text-center">
    Uno de los jugadores no tiene estadísticas disponibles para comparar.
</div>
@endif

<div class="text-center mt-4 d-flex gap-3 justify-content-center">
    <a href="{{ route('compare.index') }}" class="btn btn-nba btn-lg">
        <i class="bi bi-arrow-repeat me-2"></i>Nueva comparación
    </a>
    <a href="{{ route('players.index') }}" class="btn btn-outline-secondary btn-lg">
        <i class="bi bi-people-fill me-2"></i>Ver jugadores
    </a>
</div>

@endsection

@section('scripts')
@if($s1 && $s2)
<script>
    const ctx = document.getElementById('radarChart').getContext('2d');
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Puntos', 'Rebotes', 'Asistencias', 'Robos', 'Tapones', 'FG%'],
            datasets: [
                {
                    label: '{{ $player1->full_name }}',
                    data: [
                        {{ min($s1->pts / 35 * 100, 100) }},
                        {{ min($s1->reb / 15 * 100, 100) }},
                        {{ min($s1->ast / 12 * 100, 100) }},
                        {{ min($s1->stl / 3 * 100, 100) }},
                        {{ min($s1->blk / 4 * 100, 100) }},
                        {{ min($s1->fg_pct * 100, 100) }},
                    ],
                    backgroundColor: 'rgba(248, 194, 0, 0.2)',
                    borderColor: '#f8c200',
                    pointBackgroundColor: '#f8c200',
                    pointRadius: 5,
                },
                {
                    label: '{{ $player2->full_name }}',
                    data: [
                        {{ min($s2->pts / 35 * 100, 100) }},
                        {{ min($s2->reb / 15 * 100, 100) }},
                        {{ min($s2->ast / 12 * 100, 100) }},
                        {{ min($s2->stl / 3 * 100, 100) }},
                        {{ min($s2->blk / 4 * 100, 100) }},
                        {{ min($s2->fg_pct * 100, 100) }},
                    ],
                    backgroundColor: 'rgba(13, 202, 240, 0.2)',
                    borderColor: '#0dcaf0',
                    pointBackgroundColor: '#0dcaf0',
                    pointRadius: 5,
                }
            ]
        },
        options: {
            scales: {
                r: {
                    min: 0,
                    max: 100,
                    ticks: { display: false },
                    grid: { color: '#333' },
                    pointLabels: { color: '#aaa', font: { size: 12 } }
                }
            },
            plugins: {
                legend: { labels: { color: '#fff' } }
            }
        }
    });
</script>
@endif
@endsection