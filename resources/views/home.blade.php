@extends('layouts.app')

@section('title', 'Inicio - NBA Simulator')

@section('styles')
<style>
    .stat-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #0d0d0d 100%);
        border: 1px solid #2a2a4a;
        border-radius: 12px;
        transition: transform 0.2s, border-color 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        border-color: #f8c200;
    }
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #f8c200;
        line-height: 1;
    }
    .nav-card {
        background: #1a1a2e;
        border: 1px solid #2a2a4a;
        border-radius: 12px;
        transition: transform 0.2s, border-color 0.2s;
        cursor: pointer;
    }
    .nav-card:hover {
        transform: translateY(-4px);
        border-color: #f8c200;
    }
    .top-player-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 0;
        border-bottom: 1px solid #2a2a4a;
    }
    .top-player-row:last-child {
        border-bottom: none;
    }
    .rank-badge {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #2a2a4a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: bold;
        color: #aaa;
        flex-shrink: 0;
    }
    .rank-badge.gold   { background: #FFD700; color: #000; }
    .rank-badge.silver { background: #C0C0C0; color: #000; }
    .rank-badge.bronze { background: #CD7F32; color: #000; }
    .section-title {
        font-size: 1rem;
        font-weight: bold;
        color: #f8c200;
        border-left: 3px solid #f8c200;
        padding-left: 10px;
        margin-bottom: 16px;
    }

    .hero-section {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    background-image: url('https://images.unsplash.com/photo-1504450758481-7338eba7524a?w=1920&q=80');
    background-size: cover;
    background-position: center top;
    min-height: 320px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-overlay {
    position: relative;
    z-index: 2;
    padding: 60px 20px;
    width: 100%;
    background: rgba(0, 0, 0, 0.35);
}

.hero-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(13, 13, 13, 0.3) 0%,
        rgba(26, 26, 46, 0.3) 100%
    );
    z-index: 1;
}
</style>
@endsection

@section('content')

{{-- HERO CON IMAGEN DE FONDO --}}
<div class="hero-section text-center mb-5">
    <div class="hero-overlay">
        <h1 class="display-3 fw-bold text-warning mb-3">🏀 NBA Simulator</h1>
        <p class="lead text-white mb-4">
            Estadísticas reales · Simulación de partidos · Análisis de lesiones
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('simulator.index') }}" class="btn btn-nba btn-lg">
                <i class="bi bi-play-fill me-2"></i>Simular partido
            </a>
        </div>
    </div>
</div>

{{-- ESTADÍSTICAS GLOBALES CON ANIMACIÓN --}}
<div class="row g-3 mb-5">
    <div class="col-6 col-md-3">
        <div class="stat-card p-4 text-center">
            <div class="stat-number counter" data-target="{{ $totalTeams }}">0</div>
            <div class="text-secondary small mt-1">
                <i class="bi bi-shield-fill text-warning me-1"></i>Equipos
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-4 text-center">
            <div class="stat-number counter" data-target="{{ $totalPlayers }}">0</div>
            <div class="text-secondary small mt-1">
                <i class="bi bi-person-fill text-warning me-1"></i>Jugadores
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-4 text-center">
            <div class="stat-number counter" data-target="{{ $totalSimulations }}">0</div>
            <div class="text-secondary small mt-1">
                <i class="bi bi-trophy-fill text-warning me-1"></i>Simulaciones
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-4 text-center">
            <div class="stat-number counter {{ $totalInjuries > 0 ? 'text-danger' : 'text-success' }}"
                 data-target="{{ $totalInjuries }}">0</div>
            <div class="text-secondary small mt-1">
                <i class="bi bi-bandaid-fill text-warning me-1"></i>Lesiones activas
            </div>
        </div>
    </div>
</div>

{{-- TOPS Y ACTIVIDAD RECIENTE --}}
<div class="row g-4 mb-4">

    {{-- TOP ANOTADORES --}}
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <div class="section-title">🏀 Top Anotadores</div>
            @foreach($topScorers as $i => $player)
            <div class="top-player-row">
                <div class="rank-badge {{ $i === 0 ? 'gold' : ($i === 1 ? 'silver' : ($i === 2 ? 'bronze' : '')) }}">
                    {{ $i + 1 }}
                </div>
                @if($player->team)
                <img src="{{ $player->team->logo_url }}"
                     style="width:24px;height:24px;object-fit:contain;">
                @endif
                <div class="flex-fill">
                    <a href="{{ route('players.show', $player) }}"
                       class="text-white text-decoration-none small fw-bold">
                        {{ $player->full_name }}
                    </a>
                    <div class="text-secondary" style="font-size:0.75rem;">
                        {{ $player->team?->abbreviation }} · {{ $player->position }}
                    </div>
                </div>
                <div class="text-warning fw-bold">
                    {{ $player->currentStats->pts }}
                </div>
            </div>
            @endforeach
            <div class="text-center mt-3">
                <a href="{{ route('rankings.index', ['category' => 'pts']) }}"
                   class="btn btn-outline-warning btn-sm">Ver ranking completo</a>
            </div>
        </div>
    </div>

    {{-- TOP REBOTEADORES --}}
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <div class="section-title">📊 Top Reboteadores</div>
            @foreach($topRebounders as $i => $player)
            <div class="top-player-row">
                <div class="rank-badge {{ $i === 0 ? 'gold' : ($i === 1 ? 'silver' : ($i === 2 ? 'bronze' : '')) }}">
                    {{ $i + 1 }}
                </div>
                @if($player->team)
                <img src="{{ $player->team->logo_url }}"
                     style="width:24px;height:24px;object-fit:contain;">
                @endif
                <div class="flex-fill">
                    <a href="{{ route('players.show', $player) }}"
                       class="text-white text-decoration-none small fw-bold">
                        {{ $player->full_name }}
                    </a>
                    <div class="text-secondary" style="font-size:0.75rem;">
                        {{ $player->team?->abbreviation }} · {{ $player->position }}
                    </div>
                </div>
                <div class="text-warning fw-bold">
                    {{ $player->currentStats->reb }}
                </div>
            </div>
            @endforeach
            <div class="text-center mt-3">
                <a href="{{ route('rankings.index', ['category' => 'reb']) }}"
                   class="btn btn-outline-warning btn-sm">Ver ranking completo</a>
            </div>
        </div>
    </div>

    {{-- TOP ASISTENCIAS --}}
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <div class="section-title">🎯 Top Asistencias</div>
            @foreach($topAssists as $i => $player)
            <div class="top-player-row">
                <div class="rank-badge {{ $i === 0 ? 'gold' : ($i === 1 ? 'silver' : ($i === 2 ? 'bronze' : '')) }}">
                    {{ $i + 1 }}
                </div>
                @if($player->team)
                <img src="{{ $player->team->logo_url }}"
                     style="width:24px;height:24px;object-fit:contain;">
                @endif
                <div class="flex-fill">
                    <a href="{{ route('players.show', $player) }}"
                       class="text-white text-decoration-none small fw-bold">
                        {{ $player->full_name }}
                    </a>
                    <div class="text-secondary" style="font-size:0.75rem;">
                        {{ $player->team?->abbreviation }} · {{ $player->position }}
                    </div>
                </div>
                <div class="text-warning fw-bold">
                    {{ $player->currentStats->ast }}
                </div>
            </div>
            @endforeach
            <div class="text-center mt-3">
                <a href="{{ route('rankings.index', ['category' => 'ast']) }}"
                   class="btn btn-outline-warning btn-sm">Ver ranking completo</a>
            </div>
        </div>
    </div>
</div>

{{-- ACTIVIDAD RECIENTE --}}
<div class="row g-4">

    {{-- ÚLTIMAS SIMULACIONES --}}
    <div class="col-md-6">
        <div class="card p-4">
            <div class="section-title">⚡ Últimas simulaciones</div>
            @if($recentSimulations->count() > 0)
                @foreach($recentSimulations as $sim)
                <div class="d-flex align-items-center gap-3 py-2 border-bottom border-secondary">
                    <img src="{{ $sim->homeTeam->logo_url }}"
                         style="width:28px;height:28px;object-fit:contain;">
                    <div class="flex-fill">
                        <div class="small text-white fw-bold">
                            {{ $sim->homeTeam->abbreviation }}
                            <span class="text-warning mx-1">
                                {{ $sim->home_score }} - {{ $sim->away_score }}
                            </span>
                            {{ $sim->awayTeam->abbreviation }}
                        </div>
                        <div class="text-secondary" style="font-size:0.75rem;">
                            {{ $sim->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <img src="{{ $sim->awayTeam->logo_url }}"
                         style="width:28px;height:28px;object-fit:contain;">
                </div>
                @endforeach
                <div class="text-center mt-3">
                    <a href="{{ route('simulator.index') }}"
                       class="btn btn-nba btn-sm">Nueva simulación</a>
                </div>
            @else
                <div class="text-center py-3">
                    <p class="text-secondary small mb-2">No hay simulaciones todavía.</p>
                    <a href="{{ route('simulator.index') }}" class="btn btn-nba btn-sm">
                        Simular partido
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- LESIONES ACTIVAS --}}
    <div class="col-md-6">
        <div class="card p-4">
            <div class="section-title">🏥 Lesiones activas</div>
            @if($recentInjuries->count() > 0)
                @foreach($recentInjuries as $injury)
                <div class="d-flex align-items-center gap-3 py-2 border-bottom border-secondary">
                    @if($injury->player->team)
                    <img src="{{ $injury->player->team->logo_url }}"
                         style="width:28px;height:28px;object-fit:contain;">
                    @endif
                    <div class="flex-fill">
                        <div class="small text-white fw-bold">
                            {{ $injury->player->full_name }}
                        </div>
                        <div class="text-secondary" style="font-size:0.75rem;">
                            {{ $injury->description }}
                        </div>
                    </div>
                    {!! $injury->status_badge !!}
                </div>
                @endforeach
                <div class="text-center mt-3">
                    <a href="{{ route('injuries.index') }}"
                       class="btn btn-outline-warning btn-sm">Ver todas</a>
                </div>
            @else
                <div class="text-center py-3">
                    <i class="bi bi-emoji-smile fs-2 text-success"></i>
                    <p class="text-secondary small mt-2 mb-0">No hay lesiones activas.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Animación de contadores al cargar la página
    function animateCounter(element) {
        const target   = parseInt(element.getAttribute('data-target'));
        const duration = 1500; // milisegundos
        const step     = target / (duration / 16);
        let current    = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current);
        }, 16);
    }

    // Usar IntersectionObserver para animar cuando sean visibles
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    // Observar todos los contadores
    document.querySelectorAll('.counter').forEach(counter => {
        observer.observe(counter);
    });
</script>
@endsection