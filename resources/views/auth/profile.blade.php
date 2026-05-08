@extends('layouts.app')

@section('title', 'Mi Perfil - NBA Simulator')

@section('styles')
<style>
    .profile-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: #f8c200;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        font-weight: bold;
        color: #000;
        flex-shrink: 0;
    }
    .section-title {
        font-size: 1rem;
        font-weight: bold;
        color: #f8c200;
        border-left: 3px solid #f8c200;
        padding-left: 10px;
        margin-bottom: 16px;
    }
    .stat-box {
        background: #0d0d0d;
        border-radius: 10px;
        padding: 16px;
        text-align: center;
    }
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #f8c200;
        line-height: 1;
    }
</style>
@endsection

@section('content')

{{-- CABECERA PERFIL --}}
<div class="card p-4 mb-4">
    <div class="d-flex align-items-center gap-4 flex-wrap">
        <div class="profile-avatar">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="flex-fill">
            <h2 class="text-warning fw-bold mb-1">{{ $user->name }}</h2>
            <div class="text-secondary mb-2">
                <i class="bi bi-envelope-fill me-1"></i>{{ $user->email }}
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <span class="badge {{ $user->isAdmin() ? 'bg-danger' : 'bg-secondary' }}">
                    <i class="bi bi-person-fill me-1"></i>
                    {{ $user->isAdmin() ? 'Administrador' : 'Usuario' }}
                </span>
                <span class="badge bg-dark border border-secondary">
                    <i class="bi bi-calendar3 me-1"></i>
                    Miembro desde {{ $user->created_at->format('M Y') }}
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ESTADÍSTICAS DEL USUARIO --}}
<h5 class="text-warning mb-3">
    <i class="bi bi-bar-chart-fill me-2"></i>Tu actividad
</h5>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-box">
            <div class="stat-number">{{ $totalSimulations }}</div>
            <div class="text-secondary small mt-1">
                <i class="bi bi-trophy-fill text-warning me-1"></i>Simulaciones
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-box">
            <div class="stat-number">{{ $totalFavorites }}</div>
            <div class="text-secondary small mt-1">
                <i class="bi bi-star-fill text-warning me-1"></i>Favoritos
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-box">
            <div class="stat-number">{{ $favoriteTeams->count() }}</div>
            <div class="text-secondary small mt-1">
                <i class="bi bi-shield-fill text-warning me-1"></i>Equipos favoritos
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-box">
            <div class="stat-number">{{ $favoritePlayers->count() }}</div>
            <div class="text-secondary small mt-1">
                <i class="bi bi-person-fill text-warning me-1"></i>Jugadores favoritos
            </div>
        </div>
    </div>
</div>

{{-- EQUIPO MÁS SIMULADO Y ÚLTIMA SIMULACIÓN --}}
<div class="row g-4 mb-4">
    @if($mostSimulatedTeam)
    <div class="col-md-6">
        <div class="card p-4 text-center">
            <div class="section-title text-center" style="border-left:none;padding-left:0;">
                🏆 Equipo más simulado
            </div>
            <img src="{{ $mostSimulatedTeam->logo_url }}"
                 style="width:80px;height:80px;object-fit:contain;margin:0 auto;">
            <div class="text-warning fw-bold fs-5 mt-2">
                {{ $mostSimulatedTeam->full_name }}
            </div>
            <div class="text-secondary small">{{ $mostSimulatedTeam->conference }}ern Conference</div>
            <a href="{{ route('teams.show', $mostSimulatedTeam) }}"
               class="btn btn-outline-warning btn-sm mt-3">Ver equipo</a>
        </div>
    </div>
    @endif

    @if($lastSimulation)
    <div class="col-md-6">
        <div class="card p-4">
            <div class="section-title">⚡ Última simulación</div>
            <div class="d-flex align-items-center justify-content-between gap-3">
                <div class="text-center">
                    <img src="{{ $lastSimulation->homeTeam->logo_url }}"
                         style="width:50px;height:50px;object-fit:contain;">
                    <div class="text-white small fw-bold mt-1">
                        {{ $lastSimulation->homeTeam->abbreviation }}
                    </div>
                    <div class="badge bg-warning text-dark small">Local</div>
                </div>
                <div class="text-center">
                    <div class="fs-2 fw-bold text-warning">
                        {{ $lastSimulation->home_score }} - {{ $lastSimulation->away_score }}
                    </div>
                    <div class="text-secondary small">
                        {{ $lastSimulation->created_at->diffForHumans() }}
                    </div>
                    <div class="progress mt-2" style="height:6px;width:120px;">
                        <div class="progress-bar bg-warning"
                             style="width:{{ $lastSimulation->home_win_probability }}%"></div>
                        <div class="progress-bar bg-info"
                             style="width:{{ $lastSimulation->away_win_probability }}%"></div>
                    </div>
                </div>
                <div class="text-center">
                    <img src="{{ $lastSimulation->awayTeam->logo_url }}"
                         style="width:50px;height:50px;object-fit:contain;">
                    <div class="text-white small fw-bold mt-1">
                        {{ $lastSimulation->awayTeam->abbreviation }}
                    </div>
                    <div class="badge bg-info text-dark small">Visitante</div>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('simulations.history') }}"
                   class="btn btn-outline-warning btn-sm">Ver historial</a>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- ÚLTIMAS SIMULACIONES --}}
@if($recentSimulations->count() > 0)
<div class="card p-4 mb-4">
    <div class="section-title">🕐 Simulaciones recientes</div>
    @foreach($recentSimulations as $sim)
    <div class="d-flex align-items-center gap-3 py-2 border-bottom border-secondary">
        <img src="{{ $sim->homeTeam->logo_url }}"
             style="width:28px;height:28px;object-fit:contain;">
        <div class="flex-fill">
            <span class="text-white small fw-bold">
                {{ $sim->homeTeam->abbreviation }}
            </span>
            <span class="text-warning fw-bold mx-2">
                {{ $sim->home_score }} - {{ $sim->away_score }}
            </span>
            <span class="text-white small fw-bold">
                {{ $sim->awayTeam->abbreviation }}
            </span>
        </div>
        <img src="{{ $sim->awayTeam->logo_url }}"
             style="width:28px;height:28px;object-fit:contain;">
        <div class="text-secondary small">
            {{ $sim->created_at->diffForHumans() }}
        </div>
    </div>
    @endforeach
</div>
@endif

<div class="row g-4">

    {{-- EQUIPOS FAVORITOS --}}
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="section-title">
                ⭐ Equipos favoritos
                <span class="badge bg-secondary ms-2">{{ $favoriteTeams->count() }}</span>
            </div>
            @if($favoriteTeams->count() > 0)
                <div class="row g-2">
                    @foreach($favoriteTeams as $team)
                    <div class="col-4 text-center">
                        <a href="{{ route('teams.show', $team) }}" class="text-decoration-none">
                            <img src="{{ $team->logo_url }}"
                                 style="width:50px;height:50px;object-fit:contain;">
                            <div class="text-white small mt-1">{{ $team->abbreviation }}</div>
                        </a>
                        <form method="POST"
                              action="{{ route('favorites.team', $team) }}"
                              class="mt-1">
                            @csrf
                            <button type="submit"
                                    class="btn btn-outline-danger btn-sm"
                                    style="font-size:0.7rem;padding:2px 8px;">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-3">
                    <i class="bi bi-star fs-2 text-secondary"></i>
                    <p class="text-secondary small mt-2">
                        No tienes equipos favoritos todavía.
                    </p>
                    <a href="{{ route('teams.index') }}"
                       class="btn btn-outline-warning btn-sm">Ver equipos</a>
                </div>
            @endif
        </div>
    </div>

    {{-- JUGADORES FAVORITOS --}}
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="section-title">
                ⭐ Jugadores favoritos
                <span class="badge bg-secondary ms-2">{{ $favoritePlayers->count() }}</span>
            </div>
            @if($favoritePlayers->count() > 0)
                @foreach($favoritePlayers as $player)
                <div class="d-flex align-items-center gap-3 py-2 border-bottom border-secondary">
                    <div style="width:36px;height:36px;background:#f8c200;border-radius:50%;
                                display:flex;align-items:center;justify-content:center;
                                font-weight:bold;color:#000;flex-shrink:0;">
                        {{ strtoupper(substr($player->first_name, 0, 1)) }}
                    </div>
                    <div class="flex-fill">
                        <a href="{{ route('players.show', $player) }}"
                           class="text-white text-decoration-none fw-bold small">
                            {{ $player->full_name }}
                        </a>
                        <div class="text-secondary" style="font-size:0.75rem;">
                            {{ $player->team?->abbreviation }} · {{ $player->position }}
                        </div>
                    </div>
                    <form method="POST"
                          action="{{ route('favorites.player', $player) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                </div>
                @endforeach
            @else
                <div class="text-center py-3">
                    <i class="bi bi-star fs-2 text-secondary"></i>
                    <p class="text-secondary small mt-2">
                        No tienes jugadores favoritos todavía.
                    </p>
                    <a href="{{ route('players.index') }}"
                       class="btn btn-outline-warning btn-sm">Ver jugadores</a>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- EDITAR PERFIL --}}
<div class="row g-4 mt-2">
    <div class="col-md-6">
        <div class="card p-4">
            <div class="section-title">✏️ Editar perfil</div>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label text-secondary small">Nombre</label>
                    <input type="text" name="name"
                           class="form-control bg-dark text-white border-secondary @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small">Email</label>
                    <input type="email"
                           class="form-control bg-dark text-secondary border-secondary"
                           value="{{ $user->email }}" disabled>
                    <div class="text-secondary" style="font-size:0.75rem;" class="mt-1">
                        El email no se puede cambiar.
                    </div>
                </div>
                <button type="submit" class="btn btn-nba w-100">
                    <i class="bi bi-check-circle-fill me-2"></i>Guardar cambios
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4">
            <div class="section-title">🔐 Cambiar contraseña</div>
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label text-secondary small">Contraseña actual</label>
                    <input type="password" name="current_password"
                           class="form-control bg-dark text-white border-secondary @error('current_password') is-invalid @enderror"
                           placeholder="Tu contraseña actual" required>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small">Nueva contraseña</label>
                    <input type="password" name="password"
                           class="form-control bg-dark text-white border-secondary @error('password') is-invalid @enderror"
                           placeholder="Mínimo 6 caracteres" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="form-label text-secondary small">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation"
                           class="form-control bg-dark text-white border-secondary"
                           placeholder="Repite la nueva contraseña" required>
                </div>
                <button type="submit" class="btn btn-nba w-100">
                    <i class="bi bi-lock-fill me-2"></i>Cambiar contraseña
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ELIMINAR CUENTA --}}
<div class="card p-4 mt-4" style="border: 1px solid #dc3545;">
    <div class="section-title" style="color:#dc3545;border-left-color:#dc3545;">
        ⚠️ Zona de peligro
    </div>
    <p class="text-secondary small mb-3">
        Una vez elimines tu cuenta todos tus datos, favoritos y simulaciones
        serán eliminados permanentemente. Esta acción no se puede deshacer.
    </p>
    <button type="button" class="btn btn-outline-danger"
            data-bs-toggle="modal" data-bs-target="#deleteModal">
        <i class="bi bi-trash-fill me-2"></i>Eliminar mi cuenta
    </button>
</div>

{{-- MODAL CONFIRMAR ELIMINACIÓN --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:#1a1a2e;border:1px solid #dc3545;">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Eliminar cuenta
                </h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-secondary">
                    ¿Estás seguro de que quieres eliminar tu cuenta?
                    Esta acción es <strong class="text-danger">permanente e irreversible</strong>.
                </p>
                <form method="POST" action="{{ route('profile.delete') }}" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <label class="form-label text-secondary small">
                            Confirma tu contraseña para continuar
                        </label>
                        <input type="password" name="password"
                               class="form-control bg-dark text-white border-secondary @error('password') is-invalid @enderror"
                               placeholder="Tu contraseña" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="deleteForm" class="btn btn-danger">
                    <i class="bi bi-trash-fill me-2"></i>Eliminar cuenta
                </button>
            </div>
        </div>
    </div>
</div>

@endsection