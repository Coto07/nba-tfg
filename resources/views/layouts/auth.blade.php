<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NBA Simulator')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            background-color: #0d0d0d;
            color: #f0f0f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .auth-container {
            width: 100%;
            max-width: 440px;
            padding: 20px;
        }
        .auth-card {
            background: #1a1a2e;
            border: 1px solid #2a2a4a;
            border-radius: 16px;
            padding: 40px;
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 32px;
        }
        .auth-logo h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #f8c200;
            margin-bottom: 4px;
        }
        .auth-logo p {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
        }
        .form-control {
            background-color: #0d0d0d !important;
            border-color: #2a2a4a !important;
            color: #f0f0f0 !important;
            padding: 12px 16px;
            border-radius: 8px;
        }
        .form-control:focus {
            border-color: #f8c200 !important;
            box-shadow: 0 0 0 0.2rem rgba(248, 194, 0, 0.15) !important;
        }
        .form-control::placeholder { color: #555 !important; }
        .form-label {
            color: #aaa;
            font-size: 0.85rem;
            margin-bottom: 6px;
        }
        .btn-nba {
            background-color: #f8c200;
            color: #000;
            font-weight: bold;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            transition: background 0.2s;
        }
        .btn-nba:hover {
            background-color: #e0a800;
            color: #000;
        }
        .divider {
            text-align: center;
            color: #555;
            font-size: 0.85rem;
            margin: 20px 0;
            position: relative;
        }
        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: #2a2a4a;
        }
        .divider::before { left: 0; }
        .divider::after { right: 0; }
        .auth-footer {
            text-align: center;
            margin-top: 24px;
            color: #6c757d;
            font-size: 0.85rem;
        }
        .auth-footer a {
            color: #f8c200;
            text-decoration: none;
            font-weight: bold;
        }
        .auth-footer a:hover { text-decoration: underline; }
        .invalid-feedback { font-size: 0.8rem; }
        .alert {
            border-radius: 8px;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="auth-container">

        {{-- Logo --}}
        <div class="auth-logo">
            <h1>🏀 NBA Simulator</h1>
            <p>Estadísticas · Simulaciones · Análisis</p>
        </div>

        {{-- Alertas --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Contenido --}}
        <div class="auth-card">
            @yield('content')
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>