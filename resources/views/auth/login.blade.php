@extends('layouts.auth')

@section('title', 'Login - NBA Simulator')

@section('content')

<div class="text-center mb-4">
    <i class="bi bi-box-arrow-in-right fs-1 text-warning"></i>
    <h3 class="text-warning mt-2 fw-bold">Iniciar sesión</h3>
    <p class="text-secondary small mb-0">Bienvenido de nuevo</p>
</div>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               placeholder="tu@email.com"
               value="{{ old('email') }}" required autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input type="password" name="password"
               class="form-control"
               placeholder="Tu contraseña" required>
    </div>

    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div class="form-check">
            <input type="checkbox" name="remember"
                   class="form-check-input" id="remember">
            <label class="form-check-label text-secondary small" for="remember">
                Recordarme
            </label>
        </div>
    </div>

    <button type="submit" class="btn btn-nba w-100">
        <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión
    </button>
</form>

<div class="divider">o</div>

<div class="auth-footer">
    ¿No tienes cuenta?
    <a href="{{ route('register') }}">Regístrate gratis</a>
</div>

@endsection