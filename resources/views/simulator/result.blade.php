@extends('layouts.app')

@section('title', 'Resultado - NBA Simulator')

@section('styles')
<style>
    .scoreboard {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        background-image: url('https://images.unsplash.com/photo-1519861531473-9200262188bf?w=1920&q=80');
        background-size: cover;
        background-position: center;
        border: 2px solid #f8c200;
    }
    .scoreboard::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(10, 10, 26, 0.82);
        z-index: 0;
    }
    .scoreboard-content {
        position: relative;
        z-index: 1;
        padding: 30px;
    }
    .quarter-table th {
        color: #f8c200;
        font-size: 0.85rem;
        text-align: center;
    }
    .quarter-table td {
        text-align: center;
        font-size: 1rem;
        padding: 10px 16px;
    }
    .quarter-table .total-col {
        font-size: 1.4rem;
        font-weight: bold;
        color: #f8c200;
        border-left: 2px solid #f8c200;
    }
    .team-logo-result {
        width: 90px;
        height: 90px;
        object-fit: contain;
    }
    .winner-glow {
        filter: drop-shadow(0 0 12px #f8c200);
    }
    .vs-badge {
        background: #f8c200;
        color: #000;
        font-weight: bold;
        border-radius: 50%;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        margin: 0 auto;
    }
</style>
@endsection

@section('content')

{{-- MARCADOR PRINCIPAL --}}
<div class="scoreboard mb-4">
    <div class="scoreboard-content">

        <div class="text-center mb-3">
            <span class="badge bg-warning text-dark px-3 py-2 fs-6">
                <i class="bi bi-trophy-fill me-1"></i> RESULTADO FINAL
            </span>
        </div>

        <div class="row align-items-center justify-content-center g-3">

            {{-- Equipo local --}}
            <div class="col-5 text-center">
                <img src="{{ $result['home_team']->logo_url }}"
                     alt="{{ $result['home_team']->full_name }}"
                     class="team-logo-result {{ $result['home_score'] > $result['away_score'] ? 'winner-glow' : '' }} mb-2">
                <div class="fw-bold text-white">{{ $result['home_team']->full_name }}</div>
                <div class="badge bg-warning text-dark mb-2">LOCAL</div>
                <div class="display-3 fw-bold {{ $result['home_score'] > $result['away_score'] ? 'text-warning' : 'text-white' }}">
                    {{ $result['home_score'] }}
                </div>
            </div>

            {{-- VS --}}
            <div class="col-2 text-center">
                <div class="vs-badge">VS</div>
                <div class="mt-3 text-center">
                    <div class="small text-secondary">Ganador</div>
                    <img src="{{ $result['winner']->logo_url }}"
                         alt="{{ $result['winner']->abbreviation }}"
                         style="width:36px;height:36px;object-fit:contain;">
                    <div class="small text-warning fw-bold">{{ $result['winner']->abbreviation }}</div>
                </div>
            </div>

            {{-- Equipo visitante --}}
            <div class="col-5 text-center">
                <img src="{{ $result['away_team']->logo_url }}"
                     alt="{{ $result['away_team']->full_name }}"
                     class="team-logo-result {{ $result['away_score'] > $result['home_score'] ? 'winner-glow' : '' }} mb-2">
                <div class="fw-bold text-white">{{ $result['away_team']->full_name }}</div>
                <div class="badge bg-info text-dark mb-2">VISITANTE</div>
                <div class="display-3 fw-bold {{ $result['away_score'] > $result['home_score'] ? 'text-warning' : 'text-white' }}">
                    {{ $result['away_score'] }}
                </div>
            </div>
        </div>

        {{-- TABLA DE PARCIALES --}}
        @if(isset($result['quarters']))
        <div class="mt-4 table-responsive">
            <table class="table table-borderless quarter-table mb-0">
                <thead>
                    <tr>
                        <th class="text-start text-secondary" style="width:200px;">Equipo</th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q4</th>
                        <th class="total-col">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-white">
                        <td class="text-start">
                            <img src="{{ $result['home_team']->logo_url }}"
                                 style="width:24px;height:24px;object-fit:contain;" class="me-2">
                            {{ $result['home_team']->abbreviation }}
                        </td>
                        @foreach($result['quarters']['home'] as $q)
                            <td>{{ $q }}</td>
                        @endforeach
                        <td class="total-col">{{ $result['home_score'] }}</td>
                    </tr>
                    <tr class="text-white">
                        <td class="text-start">
                            <img src="{{ $result['away_team']->logo_url }}"
                                 style="width:24px;height:24px;object-fit:contain;" class="me-2">
                            {{ $result['away_team']->abbreviation }}
                        </td>
                        @foreach($result['quarters']['away'] as $q)
                            <td>{{ $q }}</td>
                        @endforeach
                        <td class="total-col">{{ $result['away_score'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif

        {{-- Probabilidades --}}
        <div class="mt-4 px-2">
            <div class="d-flex justify-content-between small text-secondary mb-1">
                <span>{{ $result['home_team']->abbreviation }} {{ $result['home_win_prob'] }}%</span>
                <span>Probabilidad de victoria</span>
                <span>{{ $result['away_win_prob'] }}% {{ $result['away_team']->abbreviation }}</span>
            </div>
            <div class="progress" style="height:12px;border-radius:8px;">
                <div class="progress-bar bg-warning"
                     style="width:{{ $result['home_win_prob'] }}%;border-radius:8px 0 0 8px;">
                </div>
                <div class="progress-bar bg-info"
                     style="width:{{ $result['away_win_prob'] }}%;border-radius:0 8px 8px 0;">
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ANÁLISIS DE FUERZA --}}
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <h5 class="text-warning mb-3">
                <img src="{{ $result['home_team']->logo_url }}"
                     style="width:28px;height:28px;object-fit:contain;" class="me-2">
                {{ $result['home_team']->abbreviation }} — Análisis
            </h5>
            <div class="mb-2">
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-secondary">⚔️ Ataque</small>
                    <small class="text-warning">{{ $result['home_strength']['offense'] }}</small>
                </div>
                <div class="progress mb-3" style="height:8px;">
                    <div class="progress-bar bg-warning"
                         style="width:{{ min($result['home_strength']['offense'] / 2, 100) }}%"></div>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-secondary">🛡️ Defensa</small>
                    <small class="text-success">{{ $result['home_strength']['defense'] }}</small>
                </div>
                <div class="progress mb-3" style="height:8px;">
                    <div class="progress-bar bg-success"
                         style="width:{{ min($result['home_strength']['defense'] / 2, 100) }}%"></div>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-secondary">🎯 Juego en equipo</small>
                    <small class="text-info">{{ $result['home_strength']['playmaker'] }}</small>
                </div>
                <div class="progress" style="height:8px;">
                    <div class="progress-bar bg-info"
                         style="width:{{ min($result['home_strength']['playmaker'] / 2, 100) }}%"></div>
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
                <img src="{{ $result['away_team']->logo_url }}"
                     style="width:28px;height:28px;object-fit:contain;" class="me-2">
                {{ $result['away_team']->abbreviation }} — Análisis
            </h5>
            <div class="mb-2">
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-secondary">⚔️ Ataque</small>
                    <small class="text-warning">{{ $result['away_strength']['offense'] }}</small>
                </div>
                <div class="progress mb-3" style="height:8px;">
                    <div class="progress-bar bg-warning"
                         style="width:{{ min($result['away_strength']['offense'] / 2, 100) }}%"></div>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-secondary">🛡️ Defensa</small>
                    <small class="text-success">{{ $result['away_strength']['defense'] }}</small>
                </div>
                <div class="progress mb-3" style="height:8px;">
                    <div class="progress-bar bg-success"
                         style="width:{{ min($result['away_strength']['defense'] / 2, 100) }}%"></div>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <small class="text-secondary">🎯 Juego en equipo</small>
                    <small class="text-info">{{ $result['away_strength']['playmaker'] }}</small>
                </div>
                <div class="progress" style="height:8px;">
                    <div class="progress-bar bg-info"
                         style="width:{{ min($result['away_strength']['playmaker'] / 2, 100) }}%"></div>
                </div>
            </div>
            <div class="mt-3 p-2 rounded text-center" style="background:#0d0d0d;">
                <small class="text-secondary">Fuerza total</small>
                <div class="fs-4 fw-bold text-info">{{ $result['away_strength']['total'] }}</div>
            </div>
        </div>
    </div>
</div>

{{-- JUGADORES CLAVE --}}
<div class="row g-4 mb-4">
    @foreach(['home' => 'warning', 'away' => 'info'] as $side => $color)
    <div class="col-md-6">
        <div class="card p-4">
            <h5 class="text-{{ $color }} mb-3">
                <img src="{{ $result[$side . '_team']->logo_url }}"
                     style="width:24px;height:24px;object-fit:contain;" class="me-2">
                Jugadores clave — {{ $result[$side . '_team']->abbreviation }}
            </h5>
            @foreach($result[$side . '_strength']['details'] as $detail)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <div>
                    <span class="fw-bold text-white">{{ $detail['player']->full_name }}</span>
                    @if($detail['injured'])
                        {!! $detail['player']->activeInjury->status_badge !!}
                    @endif
                    <div class="small text-secondary mt-1">
                        <span class="me-2">🏀 {{ $detail['player']->currentStats->pts }} pts</span>
                        <span class="me-2">📊 {{ $detail['player']->currentStats->reb }} reb</span>
                        <span>🎯 {{ $detail['player']->currentStats->ast }} ast</span>
                    </div>
                </div>
                <div class="text-end">
                    @if($detail['factor'] < 1.0)
                        <span class="badge bg-danger">
                            {{ (int)($detail['factor'] * 100) }}%
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

{{-- INFORME DE LESIONES --}}
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

{{-- GRÁFICA COMPARATIVA --}}
<div class="card p-4 mb-4">
    <h5 class="text-warning mb-3">
        <i class="bi bi-bar-chart-fill me-2"></i>Comparativa de equipos
    </h5>
    <canvas id="compareChart" height="80"></canvas>
</div>

{{-- GRÁFICA DE PARCIALES --}}
@if(isset($result['quarters']))
<div class="card p-4 mb-4">
    <h5 class="text-warning mb-3">
        <i class="bi bi-graph-up me-2"></i>Evolución por cuartos
    </h5>
    <canvas id="quartersChart" height="80"></canvas>
</div>
@endif

<div class="text-center mt-4 d-flex gap-3 justify-content-center flex-wrap">
    <a href="{{ route('simulator.index') }}" class="btn btn-nba btn-lg">
        <i class="bi bi-arrow-repeat me-2"></i>Nueva simulación
    </a>
    @if(isset($simulation))
    <a href="{{ route('simulator.pdf', $simulation) }}"
       class="btn btn-outline-success btn-lg" target="_blank">
        <i class="bi bi-file-pdf-fill me-2"></i>Exportar PDF
    </a>
    @endif
    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
        <i class="bi bi-house-fill me-2"></i>Inicio
    </a>
</div>

@endsection

@section('scripts')
<script>
    // Gráfica comparativa de fuerza
    const ctx1 = document.getElementById('compareChart').getContext('2d');
    new Chart(ctx1, {
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
            plugins: { legend: { labels: { color: '#fff' } } },
            scales: {
                x: { ticks: { color: '#aaa' }, grid: { color: '#333' } },
                y: { ticks: { color: '#aaa' }, grid: { color: '#333' } }
            }
        }
    });

    @if(isset($result['quarters']))
    // Gráfica de evolución por cuartos
    const ctx2 = document.getElementById('quartersChart').getContext('2d');
    const homeQ = {{ json_encode($result['quarters']['home']) }};
    const awayQ = {{ json_encode($result['quarters']['away']) }};
    const homeAcc = homeQ.map((v, i) => homeQ.slice(0, i + 1).reduce((a, b) => a + b, 0));
    const awayAcc = awayQ.map((v, i) => awayQ.slice(0, i + 1).reduce((a, b) => a + b, 0));

    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            datasets: [
                {
                    label: '{{ $result["home_team"]->abbreviation }} (Local)',
                    data: homeAcc,
                    borderColor: '#f8c200',
                    backgroundColor: 'rgba(248, 194, 0, 0.1)',
                    pointBackgroundColor: '#f8c200',
                    pointRadius: 6,
                    tension: 0.3,
                    fill: true,
                },
                {
                    label: '{{ $result["away_team"]->abbreviation }} (Visitante)',
                    data: awayAcc,
                    borderColor: '#0dcaf0',
                    backgroundColor: 'rgba(13, 202, 240, 0.1)',
                    pointBackgroundColor: '#0dcaf0',
                    pointRadius: 6,
                    tension: 0.3,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: '#fff' } } },
            scales: {
                x: { ticks: { color: '#aaa' }, grid: { color: '#333' } },
                y: { ticks: { color: '#aaa' }, grid: { color: '#333' } }
            }
        }
    });
    @endif
</script>
@endsection