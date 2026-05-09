@extends('layouts.app')

@section('title', $player->full_name . ' - NBA Simulator')

@section('content')

{{-- Cabecera --}}
<div class="card mb-4 p-4">
    <div class="row align-items-center">
        <div class="col-auto">
            <div style="width:80px;height:80px;background:#f8c200;border-radius:50%;
                        display:flex;align-items:center;justify-content:center;font-size:2rem;">
                {{ strtoupper(substr($player->first_name, 0, 1)) }}
            </div>
        </div>
        <div class="col">
            <h1 class="text-warning fw-bold mb-1">{{ $player->full_name }}</h1>
            <div class="d-flex gap-2 flex-wrap">
                @if($player->team)
                    <a href="{{ route('teams.show', $player->team) }}" class="text-decoration-none">
                        <span class="badge bg-warning text-dark fs-6">{{ $player->team->full_name }}</span>
                    </a>
                @endif
                <span class="badge bg-secondary fs-6">{{ $player->position ?? 'N/A' }}</span>
                @if($player->activeInjury)
                    {!! $player->activeInjury->status_badge !!}
                @else
                    <span class="badge bg-success">Sano</span>
                @endif
            </div>
            <div class="mt-2 text-secondary small">
                @if($player->height) <span class="me-3"><i class="bi bi-rulers"></i> {{ $player->height }}</span> @endif
                @if($player->weight) <span class="me-3"><i class="bi bi-activity"></i> {{ $player->weight }} lbs</span> @endif
                @if($player->college) <span class="me-3"><i class="bi bi-mortarboard-fill"></i> {{ $player->college }}</span> @endif
                @if($player->country) <span><i class="bi bi-globe"></i> {{ $player->country }}</span> @endif
            </div>
        </div>
    </div>
</div>

@if($stats)
{{-- Estadísticas principales --}}
<h4 class="text-warning mb-3"><i class="bi bi-bar-chart-fill me-2"></i>Temporada 2023-24</h4>

<div class="row g-3 mb-4">
    @foreach([
    ['label' => 'Puntos', 'value' => $stats->pts, 'icon' => 'bi-star-fill', 'color' => 'warning', 'tip' => 'Promedio de puntos anotados por partido'],
    ['label' => 'Rebotes', 'value' => $stats->reb, 'icon' => 'bi-arrow-up-circle-fill', 'color' => 'info', 'tip' => 'Promedio de rebotes capturados por partido'],
    ['label' => 'Asistencias', 'value' => $stats->ast, 'icon' => 'bi-people-fill', 'color' => 'success', 'tip' => 'Promedio de asistencias por partido'],
    ['label' => 'Robos', 'value' => $stats->stl, 'icon' => 'bi-hand-index-fill', 'color' => 'primary', 'tip' => 'Promedio de robos de balón por partido'],
    ['label' => 'Tapones', 'value' => $stats->blk, 'icon' => 'bi-shield-fill', 'color' => 'danger', 'tip' => 'Promedio de tapones por partido'],
    ['label' => 'Minutos', 'value' => $stats->min, 'icon' => 'bi-clock-fill', 'color' => 'secondary', 'tip' => 'Promedio de minutos jugados por partido'],
] as $stat)
    <div class="col-6 col-md-4 col-lg-2">
    <div class="card text-center p-3"
         data-bs-toggle="tooltip"
         data-bs-placement="top"
         title="{{ $stat['tip'] }}">
        <i class="bi {{ $stat['icon'] }} fs-3 text-{{ $stat['color'] }}"></i>
        <div class="fs-3 fw-bold text-white mt-1">{{ $stat['value'] }}</div>
        <div class="text-secondary small">{{ $stat['label'] }}</div>
    </div>
</div>
    @endforeach
</div>

{{-- Porcentajes --}}
<h5 class="text-warning mb-3"><i class="bi bi-percent me-2"></i>Porcentajes de tiro</h5>
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary">FG%</span>
                <span class="fw-bold text-warning">{{ number_format($stats->fg_pct * 100, 1) }}%</span>
            </div>
            <div class="progress" style="height:8px;">
                <div class="progress-bar bg-warning" style="width: {{ $stats->fg_pct * 100 }}%"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary">3P%</span>
                <span class="fw-bold text-info">{{ number_format($stats->fg3_pct * 100, 1) }}%</span>
            </div>
            <div class="progress" style="height:8px;">
                <div class="progress-bar bg-info" style="width: {{ $stats->fg3_pct * 100 }}%"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary">FT%</span>
                <span class="fw-bold text-success">{{ number_format($stats->ft_pct * 100, 1) }}%</span>
            </div>
            <div class="progress" style="height:8px;">
                <div class="progress-bar bg-success" style="width: {{ $stats->ft_pct * 100 }}%"></div>
            </div>
        </div>
    </div>
</div>

{{-- Gráfica de radar --}}
<h5 class="text-warning mb-3"><i class="bi bi-diagram-3-fill me-2"></i>Perfil de jugador</h5>
<div class="card p-4 mb-4">
    <canvas id="radarChart" height="120"></canvas>
</div>

@else
<div class="alert alert-secondary">
    <i class="bi bi-info-circle me-2"></i>
    No hay estadísticas disponibles para este jugador en la temporada 2023-24.
</div>
@endif

{{-- Lesión activa --}}
@if($player->activeInjury)
<div class="alert alert-danger">
    <i class="bi bi-bandaid-fill me-2"></i>
    <strong>Lesión activa:</strong> {{ $player->activeInjury->description }}
    — Estado: {!! $player->activeInjury->status_badge !!}
    @if($player->activeInjury->expected_return)
        — Regreso estimado: {{ $player->activeInjury->expected_return->format('d/m/Y') }}
    @endif
</div>
@endif

{{-- Botones --}}
<div class="d-flex gap-3 flex-wrap mt-3">
    @auth
    <form method="POST" action="{{ route('favorites.player', $player) }}" class="d-inline">
        @csrf
        <button type="submit"
                class="btn btn-lg {{ $player->isFavoritedBy(Auth::user()) ? 'btn-warning' : 'btn-outline-warning' }}">
            <i class="bi bi-star{{ $player->isFavoritedBy(Auth::user()) ? '-fill' : '' }} me-1"></i>
            {{ $player->isFavoritedBy(Auth::user()) ? 'En favoritos' : 'Añadir a favoritos' }}
        </button>
    </form>
    @endauth

    <a href="{{ route('compare.index') }}" class="btn btn-outline-secondary btn-lg">
        <i class="bi bi-arrows-angle-expand me-1"></i>Comparar
    </a>

    <a href="{{ route('players.index') }}" class="btn btn-outline-warning btn-lg">
        <i class="bi bi-arrow-left"></i> Volver a jugadores
    </a>
</div>

@endsection

@section('scripts')
@if($stats)
<script>
    const ctx = document.getElementById('radarChart').getContext('2d');
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Puntos', 'Rebotes', 'Asistencias', 'Robos', 'Tapones', 'FG%'],
            datasets: [{
                label: '{{ $player->full_name }}',
                data: [
                    {{ min($stats->pts / 35 * 100, 100) }},
                    {{ min($stats->reb / 15 * 100, 100) }},
                    {{ min($stats->ast / 12 * 100, 100) }},
                    {{ min($stats->stl / 3 * 100, 100) }},
                    {{ min($stats->blk / 4 * 100, 100) }},
                    {{ min($stats->fg_pct * 100, 100) }},
                ],
                backgroundColor: 'rgba(248, 194, 0, 0.2)',
                borderColor: '#f8c200',
                pointBackgroundColor: '#f8c200',
            }]
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