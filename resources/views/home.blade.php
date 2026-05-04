@extends('layouts.app')

@section('title', 'Inicio - NBA Simulator')

@section('content')
<div class="text-center py-5">
    <h1 class="display-3 fw-bold text-warning">🏀 NBA Simulator</h1>
    <p class="lead text-secondary mt-2 mb-5">
        Estadísticas reales · Simulación de partidos · Impacto de lesiones
    </p>

    <div class="row g-4 justify-content-center">
        <div class="col-md-3">
            <div class="card h-100 text-center p-3">
                <div class="card-body">
                    <i class="bi bi-shield-fill fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Equipos</h5>
                    <p class="text-secondary small">
                        Consulta estadísticas de los 30 equipos de la NBA.
                    </p>
                    <a href="{{ route('teams.index') }}" class="btn btn-nba btn-sm mt-2">
                        Ver equipos
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center p-3">
                <div class="card-body">
                    <i class="bi bi-person-fill fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Jugadores</h5>
                    <p class="text-secondary small">
                        Explora el rendimiento individual de cada jugador.
                    </p>
                    <a href="{{ route('players.index') }}" class="btn btn-nba btn-sm mt-2">
                        Ver jugadores
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center p-3">
                <div class="card-body">
                    <i class="bi bi-bandaid-fill fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Lesiones</h5>
                    <p class="text-secondary small">
                        Gestiona el estado de lesiones de jugadores clave.
                    </p>
                    <a href="{{ route('injuries.index') }}" class="btn btn-nba btn-sm mt-2">
                        Ver lesiones
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 text-center p-3">
                <div class="card-body">
                    <i class="bi bi-trophy-fill fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Simulador</h5>
                    <p class="text-secondary small">
                        Simula partidos con datos reales y lesiones.
                    </p>
                    <a href="{{ route('simulator.index') }}" class="btn btn-nba btn-sm mt-2">
                        Simular partido
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection