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
    @yield('scripts')
</body>
</html>