@extends('layouts.app')

@section('title', $team->full_name . ' - NBA Simulator')

@section('styles')
<style>
    .team-hero {
        background: linear-gradient(135deg, #0a0a1a 0%, #1a1a2e 100%);
        border: 2px solid #2a2a4a;
        border-radius: 16px;
    }
    .award-card {
        background: #0d0d0d;
        border: 1px solid #2a2a4a;
        border-radius: 10px;
        transition: border-color 0.2s;
    }
    .award-card:hover {
        border-color: #f8c200;
    }
    .avg-card {
        background: #0d0d0d;
        border-radius: 8px;
        padding: 12px;
        text-align: center;
    }
    .avg-value {
        font-size: 1.6rem;
        font-weight: bold;
        color: #f8c200;
    }
</style>
@endsection

@section('content')

{{-- CABECERA DEL EQUIPO --}}
<div class="team-hero p-4 mb-4">
    <div class="row align-items-center">
        <div class="col-auto">
            <img src="{{ $team->logo_url }}"
                 alt="{{ $team->full_name }}"
                 style="width:110px;height:110px;object-fit:contain;"
                 onerror="this.src='https://a.espncdn.com/i/teamlogos/nba/500/nba.png'">
        </div>
        <div class="col">
            <h1 class="text-warning fw-bold mb-1">{{ $team->full_name }}</h1>
            <div class="d-flex gap-2 flex-wrap mb-2">
                <span class="badge bg-warning text-dark fs-6">{{ $team->abbreviation }}</span>
                <span class="badge bg-secondary">{{ $team->conference }}ern Conference</span>
                <span class="badge bg-secondary">{{ $team->division }} Division</span>
            </div>
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('simulator.index') }}?home={{ $team->id }}"
                   class="btn btn-nba btn-sm">
                    <i class="bi bi-play-fill me-1"></i>Simular partido
                </a>
                <a href="{{ route('compare.index') }}"
                   class="btn btn-outline-warning btn-sm">
                    <i class="bi bi-arrows-angle-expand me-1"></i>Comparar jugadores
                </a>
                @auth
                <form method="POST" action="{{ route('favorites.team', $team) }}" class="d-inline">
                    @csrf
                    <button type="submit"
                            class="btn btn-sm {{ $team->isFavoritedBy(Auth::user()) ? 'btn-warning' : 'btn-outline-warning' }}">
                        <i class="bi bi-star{{ $team->isFavoritedBy(Auth::user()) ? '-fill' : '' }} me-1"></i>
                        {{ $team->isFavoritedBy(Auth::user()) ? 'Favorito' : 'Añadir a favoritos' }}
                    </button>
                </form>
                @endauth
            </div>
        </div>
        <div class="col-auto text-end">
            @if($injuredPlayers->count() > 0)
            <div class="badge bg-danger fs-6 p-2">
                <i class="bi bi-bandaid-fill me-1"></i>
                {{ $injuredPlayers->count() }} lesionado{{ $injuredPlayers->count() > 1 ? 's' : '' }}
            </div>
            @else
            <div class="badge bg-success fs-6 p-2">
                <i class="bi bi-heart-fill me-1"></i>Plantilla sana
            </div>
            @endif
        </div>
    </div>
</div>

{{-- MEJORES JUGADORES POR CATEGORÍA --}}
<h5 class="text-warning mb-3">
    <i class="bi bi-star-fill me-2"></i>Mejores jugadores
</h5>
<div class="row g-3 mb-4">
    @foreach([
        ['label' => 'Máximo anotador', 'player' => $topScorer, 'stat' => 'pts', 'icon' => '🏀', 'unit' => 'pts'],
        ['label' => 'Máximo reboteador', 'player' => $topRebounder, 'stat' => 'reb', 'icon' => '📊', 'unit' => 'reb'],
        ['label' => 'Máximo asistente', 'player' => $topAssister, 'stat' => 'ast', 'icon' => '🎯', 'unit' => 'ast'],
        ['label' => 'Mejor defensor', 'player' => $topDefender, 'stat' => null, 'icon' => '🛡️', 'unit' => ''],
    ] as $award)
    @if($award['player'])
    <div class="col-6 col-md-3">
        <div class="award-card p-3 text-center h-100">
            <div class="fs-2 mb-1">{{ $award['icon'] }}</div>
            <div class="text-secondary small mb-2">{{ $award['label'] }}</div>
            <a href="{{ route('players.show', $award['player']) }}"
               class="text-white text-decoration-none fw-bold d-block">
                {{ $award['player']->full_name }}
            </a>
            <div class="text-warning fw-bold mt-1">
                @if($award['stat'])
                    {{ $award['player']->currentStats->{$award['stat']} }} {{ $award['unit'] }}
                @else
                    {{ round($award['player']->currentStats->stl + $award['player']->currentStats->blk, 1) }} stl+blk
                @endif
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>

{{-- PROMEDIOS DEL EQUIPO --}}
<h5 class="text-warning mb-3">
    <i class="bi bi-bar-chart-fill me-2"></i>Promedios del equipo
</h5>
<div class="row g-3 mb-4">
    @foreach([
        ['label' => 'PTS', 'value' => $teamAverages['pts']],
        ['label' => 'REB', 'value' => $teamAverages['reb']],
        ['label' => 'AST', 'value' => $teamAverages['ast']],
        ['label' => 'STL', 'value' => $teamAverages['stl']],
        ['label' => 'BLK', 'value' => $teamAverages['blk']],
        ['label' => 'FG%', 'value' => number_format($teamAverages['fg_pct'] * 100, 1) . '%'],
        ['label' => '3P%', 'value' => number_format($teamAverages['fg3_pct'] * 100, 1) . '%'],
        ['label' => 'FT%', 'value' => number_format($teamAverages['ft_pct'] * 100, 1) . '%'],
    ] as $avg)
    <div class="col-6 col-md-3 col-lg-auto flex-fill">
        <div class="avg-card">
            <div class="avg-value">{{ $avg['value'] }}</div>
            <div class="text-secondary small">{{ $avg['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- GRÁFICA RADAR DEL EQUIPO --}}
<div class="card p-4 mb-4">
    <h5 class="text-warning mb-3">
        <i class="bi bi-diagram-3-fill me-2"></i>Perfil del equipo
    </h5>
    <canvas id="teamRadar" height="80"></canvas>
</div>

{{-- LESIONES ACTIVAS --}}
@if($injuredPlayers->count() > 0)
<div class="card p-4 mb-4" style="border-left: 3px solid #dc3545;">
    <h5 class="text-danger mb-3">
        <i class="bi bi-bandaid-fill me-2"></i>Lesiones activas
    </h5>
    <div class="row g-2">
        @foreach($injuredPlayers as $player)
        <div class="col-md-6">
            <div class="d-flex align-items-center gap-3 p-2 rounded" style="background:#0d0d0d;">
                <div style="width:40px;height:40px;background:#dc3545;border-radius:50%;
                            display:flex;align-items:center;justify-content:center;
                            font-weight:bold;color:#fff;flex-shrink:0;">
                    {{ strtoupper(substr($player->first_name, 0, 1)) }}
                </div>
                <div class="flex-fill">
                    <a href="{{ route('players.show', $player) }}"
                       class="text-white text-decoration-none fw-bold small">
                        {{ $player->full_name }}
                    </a>
                    <div class="text-secondary" style="font-size:0.75rem;">
                        {{ $player->activeInjury->description }}
                    </div>
                </div>
                {!! $player->activeInjury->status_badge !!}
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- PLANTILLA COMPLETA --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="text-warning mb-0">
        <i class="bi bi-people-fill me-2"></i>Plantilla completa
    </h5>
    <span class="badge bg-secondary">{{ $players->count() }} jugadores</span>
</div>

@if($players->count() > 0)
<div class="table-responsive mb-4">
    <table class="table table-dark table-hover align-middle">
        <thead class="text-warning">
            <tr>
                <th>Jugador</th>
                <th>Pos</th>
                <th class="text-center">PTS</th>
                <th class="text-center">REB</th>
                <th class="text-center">AST</th>
                <th class="text-center">STL</th>
                <th class="text-center">BLK</th>
                <th class="text-center">FG%</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($players as $player)
            <tr>
                <td>
                    <a href="{{ route('players.show', $player) }}"
                       class="text-white text-decoration-none fw-bold">
                        {{ $player->full_name }}
                    </a>
                </td>
                <td><span class="badge bg-secondary">{{ $player->position ?? '-' }}</span></td>
                <td class="text-center text-warning fw-bold">
                    {{ $player->currentStats?->pts ?? '-' }}
                </td>
                <td class="text-center">{{ $player->currentStats?->reb ?? '-' }}</td>
                <td class="text-center">{{ $player->currentStats?->ast ?? '-' }}</td>
                <td class="text-center">{{ $player->currentStats?->stl ?? '-' }}</td>
                <td class="text-center">{{ $player->currentStats?->blk ?? '-' }}</td>
                <td class="text-center">
                    {{ $player->currentStats
                        ? number_format($player->currentStats->fg_pct * 100, 1) . '%'
                        : '-' }}
                </td>
                <td class="text-center">
                    @if($player->activeInjury)
                        {!! $player->activeInjury->status_badge !!}
                    @else
                        <span class="badge bg-success">Sano</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- SIMULACIONES RECIENTES --}}
@if($recentSims->count() > 0)
<h5 class="text-warning mb-3">
    <i class="bi bi-trophy-fill me-2"></i>Simulaciones recientes
</h5>
<div class="row g-2 mb-4">
    @foreach($recentSims as $sim)
    @php
        $isHome    = $sim->home_team_id === $team->id;
        $opponent  = $isHome ? $sim->awayTeam : $sim->homeTeam;
        $teamScore = $isHome ? $sim->home_score : $sim->away_score;
        $oppScore  = $isHome ? $sim->away_score : $sim->home_score;
        $teamProb  = $isHome ? $sim->home_win_probability : $sim->away_win_probability;
        $won       = $teamScore > $oppScore;
    @endphp
    <div class="col-md-6">
        <div class="card p-3">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ $team->logo_url }}"
                     style="width:36px;height:36px;object-fit:contain;">
                <div class="flex-fill">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold {{ $won ? 'text-success' : 'text-danger' }}">
                            {{ $won ? 'V' : 'D' }}
                        </span>
                        <span class="text-white">
                            {{ $teamScore }} - {{ $oppScore }}
                        </span>
                        <span class="text-secondary small">vs {{ $opponent->abbreviation }}</span>
                        <img src="{{ $opponent->logo_url }}"
                             style="width:24px;height:24px;object-fit:contain;">
                    </div>
                    <div class="text-secondary" style="font-size:0.75rem;">
                        {{ $isHome ? 'Local' : 'Visitante' }} ·
                        {{ $sim->created_at->diffForHumans() }}
                    </div>
                </div>
                <div class="text-end">
                    <div class="small text-warning">{{ $teamProb }}%</div>
                    <div class="small text-secondary">prob.</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<a href="{{ route('teams.index') }}" class="btn btn-outline-warning">
    <i class="bi bi-arrow-left"></i> Volver a equipos
</a>

@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('teamRadar').getContext('2d');
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Anotación', 'Rebotes', 'Asistencias', 'Robos', 'Tapones', 'FG%'],
            datasets: [{
                label: '{{ $team->full_name }}',
                data: [
                    {{ min($teamAverages['pts'] / 30 * 100, 100) }},
                    {{ min($teamAverages['reb'] / 12 * 100, 100) }},
                    {{ min($teamAverages['ast'] / 8 * 100, 100) }},
                    {{ min($teamAverages['stl'] / 2 * 100, 100) }},
                    {{ min($teamAverages['blk'] / 2 * 100, 100) }},
                    {{ min($teamAverages['fg_pct'] * 100, 100) }},
                ],
                backgroundColor: 'rgba(248, 194, 0, 0.2)',
                borderColor: '#f8c200',
                pointBackgroundColor: '#f8c200',
                pointRadius: 5,
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
@endsection