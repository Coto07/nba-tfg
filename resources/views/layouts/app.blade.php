<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NBA Simulator')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #0d0d0d;
            color: #f0f0f0;
        }
        .navbar { border-bottom: 2px solid #f8c200; }
        .navbar-brand { font-size: 1.4rem; letter-spacing: 1px; }
        .nav-link:hover { color: #f8c200 !important; }
        .card {
            background-color: #1a1a2e;
            border: 1px solid #2a2a4a;
            border-radius: 10px;
        }
        .card-title { color: #f8c200; }
        .btn-nba {
            background-color: #f8c200;
            color: #000;
            font-weight: bold;
            border: none;
        }
        .btn-nba:hover {
            background-color: #e0a800;
            color: #000;
        }
        .text-nba { color: #f8c200; }
        .badge-conference {
            font-size: 0.7rem;
            padding: 4px 8px;
            border-radius: 20px;
        }
        footer {
            border-top: 1px solid #2a2a4a;
        }
        .search-result-item {
            transition: background 0.15s;
            border-radius: 6px;
        }
        .search-result-item:hover {
            background: #2a2a4a !important;
        }
    </style>
    @yield('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-black">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="{{ route('home') }}">
                🏀 NBA Simulator
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'text-warning fw-bold' : 'text-light' }}"
                           href="{{ route('home') }}">
                            <i class="bi bi-house-fill"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teams.*') ? 'text-warning fw-bold' : 'text-light' }}"
                           href="{{ route('teams.index') }}">
                            <i class="bi bi-shield-fill"></i> Equipos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('players.*') ? 'text-warning fw-bold' : 'text-light' }}"
                           href="{{ route('players.index') }}">
                            <i class="bi bi-person-fill"></i> Jugadores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rankings.*') ? 'text-warning fw-bold' : 'text-light' }}"
                           href="{{ route('rankings.index') }}">
                            <i class="bi bi-list-ol me-1"></i> Rankings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('compare.*') ? 'text-warning fw-bold' : 'text-light' }}"
                           href="{{ route('compare.index') }}">
                            <i class="bi bi-arrows-angle-expand me-1"></i> Comparador
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('injuries.*') ? 'text-warning fw-bold' : 'text-light' }}"
                           href="{{ route('injuries.index') }}">
                            <i class="bi bi-bandaid-fill"></i> Lesiones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('simulator.*') ? 'text-warning fw-bold' : 'text-light' }}"
                           href="{{ route('simulator.index') }}">
                            <i class="bi bi-trophy-fill"></i> Simulador
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('simulations.*') ? 'text-warning fw-bold' : 'text-light' }}"
                           href="{{ route('simulations.history') }}">
                            <i class="bi bi-clock-history me-1"></i> Historial
                        </a>
                    </li>

                    {{-- Buscador global --}}
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link text-light" href="#" id="searchDropdown"
                           data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="bi bi-search"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark dropdown-menu-end p-2"
                             style="width:320px;" aria-labelledby="searchDropdown">
                            <input type="text" id="global-search"
                                   class="form-control bg-dark text-white border-secondary"
                                   placeholder="Buscar jugador o equipo...">
                            <div id="search-results" class="mt-2"
                                 style="max-height:300px;overflow-y:auto;"></div>
                        </div>
                    </li>
                    @endauth

                    {{-- Auth --}}
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#"
                           data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="bi bi-person-fill me-2"></i>Mi perfil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'text-warning fw-bold' : 'text-light' }}"
                           href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'text-warning fw-bold' : 'text-light' }}"
                           href="{{ route('register') }}">
                            <i class="bi bi-person-plus-fill me-1"></i>Registro
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="text-center text-secondary py-4 mt-5">
        <small>🏀 NBA Simulator &mdash; David Del Coto Ramón &mdash; TFG {{ date('Y') }}</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @auth
    <script>
    document.getElementById('global-search').addEventListener('input', function () {
        const query   = this.value.trim();
        const results = document.getElementById('search-results');

        if (query.length < 2) {
            results.innerHTML = '';
            return;
        }

        results.innerHTML = '<div class="text-center py-2"><div class="spinner-border spinner-border-sm text-warning"></div></div>';

        fetch(`/search?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                results.innerHTML = '';

                if (data.players.length === 0 && data.teams.length === 0) {
                    results.innerHTML = '<p class="text-secondary small text-center py-2 mb-0">Sin resultados</p>';
                    return;
                }

                if (data.teams.length > 0) {
                    results.innerHTML += `<div class="text-secondary small px-2 py-1">Equipos</div>`;
                    data.teams.forEach(team => {
                        results.innerHTML += `
                            <a href="/teams/${team.id}"
                               class="d-flex align-items-center gap-2 text-decoration-none p-2 search-result-item">
                                <img src="${team.logo_url}"
                                     style="width:28px;height:28px;object-fit:contain;">
                                <div>
                                    <div class="text-white small fw-bold">${team.full_name}</div>
                                    <div class="text-secondary" style="font-size:0.75rem;">
                                        ${team.conference} · ${team.division}
                                    </div>
                                </div>
                            </a>`;
                    });
                }

                if (data.players.length > 0) {
                    results.innerHTML += `<div class="text-secondary small px-2 py-1 mt-1">Jugadores</div>`;
                    data.players.forEach(player => {
                        results.innerHTML += `
                            <a href="/players/${player.id}"
                               class="d-flex align-items-center gap-2 text-decoration-none p-2 search-result-item">
                                <div style="width:28px;height:28px;background:#f8c200;border-radius:50%;
                                            display:flex;align-items:center;justify-content:center;
                                            font-weight:bold;color:#000;font-size:0.75rem;flex-shrink:0;">
                                    ${player.first_name.charAt(0)}
                                </div>
                                <div>
                                    <div class="text-white small fw-bold">${player.full_name}</div>
                                    <div class="text-secondary" style="font-size:0.75rem;">
                                        ${player.team ?? 'Sin equipo'} · ${player.position ?? ''}
                                    </div>
                                </div>
                            </a>`;
                    });
                }
            })
            .catch(() => {
                results.innerHTML = '<p class="text-secondary small text-center py-2 mb-0">Error al buscar</p>';
            });
    });
    </script>
    @endauth

    @yield('scripts')
</body>
</html>