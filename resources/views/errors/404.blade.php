@extends('layouts.app')

@section('title', '404 - Página no encontrada')

@section('content')
<div class="text-center py-5">

    <div class="display-1 fw-bold text-warning mb-0">404</div>
    <div class="fs-1 mb-3">🏀</div>
    <h2 class="text-white fw-bold mb-2">¡Fuera de pista!</h2>
    <p class="text-secondary mb-4">
        La página que buscas no existe o ha sido movida.
    </p>

    <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="{{ route('home') }}" class="btn btn-nba btn-lg">
            <i class="bi bi-house-fill me-2"></i>Volver al inicio
        </a>
        <a href="{{ route('teams.index') }}" class="btn btn-outline-warning btn-lg">
            <i class="bi bi-shield-fill me-2"></i>Ver equipos
        </a>
    </div>

    <div class="mt-5 text-secondary small">
        <i class="bi bi-arrow-left me-1"></i>
        <a href="javascript:history.back()" class="text-secondary">Volver a la página anterior</a>
    </div>
</div>
@endsection