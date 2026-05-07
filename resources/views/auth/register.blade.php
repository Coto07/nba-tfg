@extends('layouts.auth')

@section('title', 'Registro - NBA Simulator')

@section('content')

<div class="text-center mb-4">
    <i class="bi bi-person-plus-fill fs-1 text-warning"></i>
    <h3 class="text-warning mt-2 fw-bold">Crear cuenta</h3>
    <p class="text-secondary small mb-0">Únete a NBA Simulator</p>
</div>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="name"
               class="form-control @error('name') is-invalid @enderror"
               placeholder="Tu nombre"
               value="{{ old('name') }}" required autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               placeholder="tu@email.com"
               value="{{ old('email') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input type="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               placeholder="Mínimo 6 caracteres" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label class="form-label">Confirmar contraseña</label>
        <input type="password" name="password_confirmation"
               class="form-control"
               placeholder="Repite la contraseña" required>
    </div>

    <button type="submit" class="btn btn-nba w-100">
        <i class="bi bi-person-plus-fill me-2"></i>Crear cuenta
    </button>
</form>

<div class="divider">o</div>

<div class="auth-footer">
    ¿Ya tienes cuenta?
    <a href="{{ route('login') }}">Inicia sesión</a>
</div>

@endsection