@extends('layouts.app')

@section('title', '404 - Página no encontrada')

@section('styles')
<style>
    .error-hero {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        background-image: url('https://images.unsplash.com/photo-1577223625816-7546f13df25d?w=1920&q=80');
        background-size: cover;
        background-position: center;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .error-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.75);
        z-index: 1;
    }
    .error-content {
        position: relative;
        z-index: 2;
        padding: 60px 20px;
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="error-hero">
    <div class="error-content">
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
        <div class="mt-4">
            <a href="javascript:history.back()" class="text-secondary">
                <i class="bi bi-arrow-left me-1"></i>Volver a la página anterior
            </a>
        </div>
    </div>
</div>
@endsection