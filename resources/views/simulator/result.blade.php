@extends('layouts.app')

@section('title', 'Resultado - NBA Simulator')

@section('content')

{{-- Resultado principal --}}
<div class="card p-4 mb-4 text-center">
    <h2 class="text-warning fw-bold mb-4">
        <i class="bi bi-trophy-fill me-2"></i>Resultado de la Simulación
    </h2>

    <div class="row align-items-center justify-content-center g-4">
        {{-- Equipo local --}}
        <div class="col-md-4 text-center">
            <img src="{{ $result['home_team']->logo_url }}"
     alt="{{ $result['home_team']->full_name }}"
     style="width:80px;height:80px;object-fit:contain;">
            <h3 class="text-warning fw-bold">{{ $result['home_team']->full_name }}</h3>
            <span class="badge bg-warning text-dark mb-2">LOCAL</span>
            <div class="display-4 fw-bold text-white">{{ $result['home_score'] }}</div>
            <div class="mt-2">
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-warning"
                         style="width: {{ $result['home_win_prob'] }}%"></div>
                </div>
                <small class="text-secondary mt-1 d-block">
                    Probabilidad de victoria: <span class="text-warning fw-bold">{{ $result['home_win_prob'] }}%</span>
                </small>
            </div>
        </div>

        {{-- VS --}}
        <div class="col-md-2 text-center">
            <div class="display-5 fw-bold text-secondary">VS</div>
            <div class="mt-3 p-2 rounded" style="background: #1a1a2e;">
                <small class="text-secondary d-block">Ganador estimado</small>
                <span class="text-warning fw-bold">{{ $result['winner']->abbreviation }}</span>
            </div>
        </div>

        {{-- Equipo visitante --}}
        <div class="col-md-4 text-center">
            <img src="{{ $result['away_team']->logo_url }}"
     alt="{{ $result['away_team']->full_name }}"
     style="width:80px;height:80px;object-fit:contain;">
            <h3 class="text-info fw-bold">{{ $result['away_team']->full_name }}</h3>
            <span class="badge bg-info text-dark mb-2">VISITANTE</span>
            <div class="display-4 fw-bold text-white">{{ $result['away_score'] }}</div>
            <div class="mt-2">
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-info"
                         style="width: {{ $result['away_win_prob'] }}%"></div>
                </div>
                <small class="text-secondary mt-1 d-block">
                    Probabilidad de victoria: <span class="text-info fw-bold">{{ $result['away_win_prob'] }}%</span>
                </small>
            </div>
        </div>
    </div>
</div>

{{-- Análisis de fuerza --}}
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <h5 class="text-warning mb-3">
                <i class="bi bi-bar-chart-fill me-2"></i>
                {{ $result['home_team']->abbreviation }} — Análisis
            </h5>
            <div class="mb-2">
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-secondary">Ataque</small>
                    <small class="text-warning">{{ $result['home_strength']['offense'] }}</small>
                </div>
                <div class="progress mb-3" style="height:8px;">
                    <div class="progress-bar bg-warning"
                         style="width: {{ min($result['home_strength']['offense'] / 2, 100) }}%"></div>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-secondary">Defensa</small>
                    <small class="text-success">{{ $result['home_strength']['defense'] }}</small>
                </div>
                <div class="progress mb-3" style="height:8px;">
                    <div class="progress-bar bg-success"
                         style="width: {{ min($result['home_strength']['defense'] / 2, 100) }}%"></div>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-secondary">Juego en equipo</small>
                    <small class="text-info">{{ $result['home_strength']['playmaker'] }}</small>
                </div>
                <div class="progress" style="height:8px;">
                    <div class="progress-bar bg-info"
                         style="width: {{ min($result['home_strength']['playmaker'] / 2, 100) }}%"></div>
                </div>
            </div>
            <div class="mt-3 p-2 rounded text-center" style="background:#0d0d0d;">
                <small class="text-secondary">Fuerza total</small>
                <div class="fs-4 fw-bold text-warning">{{ $result['home_strength']['total'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4 h-100">
            <h5 class="text-info mb-3">
                <i class="bi bi-bar-chart-fill me-2"></i>
                {{ $result['away_team']->abbreviation }} — Análisis
            </h5>
            <div class="mb-2">
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-secondary">Ataque</small>
                    <small class="text-warning">{{ $result['away_strength']['offense'] }}</small>
                </div>
                <div class="progress mb-3" style="height:8px;">
                    <div class="progress-bar bg-warning"
                         style="width: {{ min($result['away_strength']['offense'] / 2, 100) }}%"></div>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-secondary">Defensa</small>
                    <small class="text-success">{{ $result['away_strength']['defense'] }}</small>
                </div>
                <div class="progress mb-3" style="height:8px;">
                    <div class="progress-bar bg-success"
                         style="width: {{ min($result['away_strength']['defense'] / 2, 100) }}%"></div>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-secondary">Juego en equipo</small>
                    <small class="text-info">{{ $result['away_strength']['playmaker'] }}</small>
                </div>
                <div class="progress" style="height:8px;">
                    <div class="progress-bar bg-info"
                         style="width: {{ min($result['away_strength']['playmaker'] / 2, 100) }}%"></div>
                </div>
            </div>
            <div class="mt-3 p-2 rounded text-center" style="background:#0d0d0d;">
                <small class="text-secondary">Fuerza total</small>
                <div class="fs-4 fw-bold text-info">{{ $result['away_strength']['total'] }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Jugadores clave --}}
<div class="row g-4 mb-4">
    @foreach(['home' => 'warning', 'away' => 'info'] as $side => $color)
    <div class="col-md-6">
        <div class="card p-4">
            <h5 class="text-{{ $color }} mb-3">
                <i class="bi bi-people-fill me-2"></i>
                Jugadores clave — {{ $result[$side . '_team']->abbreviation }}
            </h5>
            @foreach($result[$side . '_strength']['details'] as $detail)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <div>
                    <span class="fw-bold text-white">{{ $detail['player']->full_name }}</span>
                    @if($detail['injured'])
                        {!! $detail['player']->activeInjury->status_badge !!}
                    @endif
                    <div class="small text-secondary">
                        {{ $detail['player']->currentStats->pts }} pts |
                        {{ $detail['player']->currentStats->reb }} reb |
                        {{ $detail['player']->currentStats->ast }} ast
                    </div>
                </div>
                <div class="text-end">
                    @if($detail['factor'] < 1.0)
                        <span class="badge bg-danger">
                            {{ (int)($detail['factor'] * 100) }}% rendimiento
                        </span>
                    @else
                        <span class="badge bg-success">100%</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

{{-- Informe de lesiones --}}
@if(count($result['home_injury_report']) > 0 || count($result['away_injury_report']) > 0)
<div class="card p-4 mb-4">
    <h5 class="text-danger mb-3">
        <i class="bi bi-bandaid-fill me-2"></i>Impacto de lesiones en la simulación
    </h5>
    <div class="row g-3">
        @foreach(['home_injury_report' => $result['home_team'], 'away_injury_report' => $result['away_team']] as $key => $team)
            @if(count($result[$key]) > 0)
            <div class="col-md-6">
                <h6 class="text-secondary">{{ $team->full_name }}</h6>
                @foreach($result[$key] as $report)
                <div class="alert alert-danger py-2 mb-2">
                    <strong>{{ $report['player']->full_name }}</strong>
                    — {{ $report['injury']->description }}
                    {!! $report['injury']->status_badge !!}
                    <div class="small mt-1">
                        Rendimiento aplicado: <strong>{{ (int)($report['factor'] * 100) }}%</strong>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        @endforeach
    </div>
</div>
@endif

{{-- Gráfica comparativa --}}
<div class="card p-4 mb-4">
    <h5 class="text-warning mb-3">
        <i class="bi bi-diagram-3-fill me-2"></i>Comparativa de equipos
    </h5>
    <canvas id="compareChart" height="80"></canvas>
</div>

<div class="text-center mt-4 d-flex gap-3 justify-content-center">
    <a href="{{ route('simulator.index') }}" class="btn btn-nba btn-lg">
        <i class="bi bi-arrow-repeat me-2"></i>Nueva simulación
    </a>
    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
        <i class="bi bi-house-fill me-2"></i>Inicio
    </a>
</div>

@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('compareChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Ataque', 'Defensa', 'Juego en equipo', 'Fuerza total'],
            datasets: [
                {
                    label: '{{ $result["home_team"]->abbreviation }} (Local)',
                    data: [
                        {{ $result['home_strength']['offense'] }},
                        {{ $result['home_strength']['defense'] }},
                        {{ $result['home_strength']['playmaker'] }},
                        {{ $result['home_strength']['total'] }},
                    ],
                    backgroundColor: 'rgba(248, 194, 0, 0.7)',
                    borderColor: '#f8c200',
                    borderWidth: 1,
                },
                {
                    label: '{{ $result["away_team"]->abbreviation }} (Visitante)',
                    data: [
                        {{ $result['away_strength']['offense'] }},
                        {{ $result['away_strength']['defense'] }},
                        {{ $result['away_strength']['playmaker'] }},
                        {{ $result['away_strength']['total'] }},
                    ],
                    backgroundColor: 'rgba(13, 202, 240, 0.7)',
                    borderColor: '#0dcaf0',
                    borderWidth: 1,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { labels: { color: '#fff' } }
            },
            scales: {
                x: { ticks: { color: '#aaa' }, grid: { color: '#333' } },
                y: { ticks: { color: '#aaa' }, grid: { color: '#333' } }
            }
        }
    });
</script>
@endsection