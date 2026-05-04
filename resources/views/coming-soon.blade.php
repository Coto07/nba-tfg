@extends('layouts.app')

@section('title', $section . ' - NBA Simulator')

@section('content')
<div class="text-center py-5">
    <i class="bi bi-tools fs-1 text-warning"></i>
    <h2 class="text-warning mt-3">{{ $section }}</h2>
    <p class="text-secondary">Esta sección está en desarrollo.</p>
    <a href="{{ route('home') }}" class="btn btn-outline-warning mt-3">
        <i class="bi bi-arrow-left"></i> Volver al inicio
    </a>
</div>
@endsection