<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simulación NBA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            color: #1a1a2e;
            padding: 30px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #f8c200;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 28px;
            color: #1a1a2e;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 13px;
        }
        .badge-playoffs {
            background: #f8c200;
            color: #000;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }
        .scoreboard {
            background: #1a1a2e;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            color: #fff;
        }
        .teams-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
        }
        .team-block {
            flex: 1;
            text-align: center;
        }
        .team-name {
            font-size: 18px;
            font-weight: bold;
            color: #f8c200;
            margin-bottom: 5px;
        }
        .team-badge {
            background: #f8c200;
            color: #000;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            display: inline-block;
            margin-bottom: 10px;
        }
        .score {
            font-size: 48px;
            font-weight: bold;
            color: #fff;
        }
        .score.winner { color: #f8c200; }
        .vs-block {
            font-size: 20px;
            font-weight: bold;
            color: #666;
            padding: 0 20px;
        }
        .quarters-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #fff;
        }
        .quarters-table th {
            background: #2a2a4a;
            padding: 8px 12px;
            text-align: center;
            font-size: 12px;
            color: #f8c200;
        }
        .quarters-table td {
            padding: 8px 12px;
            text-align: center;
            font-size: 13px;
            border-bottom: 1px solid #2a2a4a;
        }
        .quarters-table .total {
            font-weight: bold;
            color: #f8c200;
            border-left: 2px solid #f8c200;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1a1a2e;
            border-left: 3px solid #f8c200;
            padding-left: 10px;
            margin-bottom: 12px;
        }
        .prob-bar {
            height: 12px;
            background: #eee;
            border-radius: 6px;
            overflow: hidden;
            margin: 8px 0;
        }
        .prob-fill-home {
            height: 100%;
            background: #f8c200;
            display: inline-block;
        }
        .prob-fill-away {
            height: 100%;
            background: #0dcaf0;
            display: inline-block;
        }
        .prob-labels {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #666;
        }
        .strength-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }
        .strength-label { color: #666; }
        .strength-home  { color: #f8c200; font-weight: bold; }
        .strength-away  { color: #0dcaf0; font-weight: bold; }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            color: #999;
            font-size: 11px;
        }
        .winner-banner {
            text-align: center;
            background: #f8c200;
            color: #000;
            padding: 10px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    {{-- CABECERA --}}
    <div class="header">
        <h1>🏀 NBA Simulator</h1>
        <p>Resultado de simulación · {{ $simulation->created_at->format('d/m/Y H:i') }}</p>
        <p>David Del Coto Ramón · TFG {{ date('Y') }}</p>
    </div>

    {{-- MARCADOR --}}
    <div class="scoreboard">
        <div class="teams-row">
            <div class="team-block">
                <div class="team-name">{{ $simulation->homeTeam->full_name }}</div>
                <div class="team-badge">LOCAL</div>
                <div class="score {{ $simulation->home_score > $simulation->away_score ? 'winner' : '' }}">
                    {{ $simulation->home_score }}
                </div>
            </div>
            <div class="vs-block">VS</div>
            <div class="team-block">
                <div class="team-name">{{ $simulation->awayTeam->full_name }}</div>
                <div class="team-badge" style="background:#0dcaf0;">VISITANTE</div>
                <div class="score {{ $simulation->away_score > $simulation->home_score ? 'winner' : '' }}">
                    {{ $simulation->away_score }}
                </div>
            </div>
        </div>

        {{-- PARCIALES --}}
        @if(isset($simulation->result_details['quarters']))
        @php $quarters = $simulation->result_details['quarters']; @endphp
        <table class="quarters-table">
            <thead>
                <tr>
                    <th style="text-align:left;">Equipo</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th class="total">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align:left;color:#f8c200;">{{ $simulation->homeTeam->abbreviation }}</td>
                    @foreach($quarters['home'] as $q)
                        <td>{{ $q }}</td>
                    @endforeach
                    <td class="total">{{ $simulation->home_score }}</td>
                </tr>
                <tr>
                    <td style="text-align:left;color:#0dcaf0;">{{ $simulation->awayTeam->abbreviation }}</td>
                    @foreach($quarters['away'] as $q)
                        <td>{{ $q }}</td>
                    @endforeach
                    <td class="total">{{ $simulation->away_score }}</td>
                </tr>
            </tbody>
        </table>
        @endif

        {{-- GANADOR --}}
        <div class="winner-banner">
            🏆 Ganador estimado:
            {{ $simulation->home_score > $simulation->away_score
                ? $simulation->homeTeam->full_name
                : $simulation->awayTeam->full_name }}
        </div>
    </div>

    {{-- PROBABILIDADES --}}
    <div class="section">
        <div class="section-title">Probabilidades de victoria</div>
        <div class="prob-labels">
            <span>{{ $simulation->homeTeam->abbreviation }} — {{ $simulation->home_win_probability }}%</span>
            <span>{{ $simulation->away_win_probability }}% — {{ $simulation->awayTeam->abbreviation }}</span>
        </div>
        <div class="prob-bar">
            <span class="prob-fill-home" style="width:{{ $simulation->home_win_probability }}%;"></span>
            <span class="prob-fill-away" style="width:{{ $simulation->away_win_probability }}%;"></span>
        </div>
    </div>

    {{-- ANÁLISIS DE FUERZA --}}
    @if(isset($simulation->result_details['home_strength']))
    @php
        $hs = $simulation->result_details['home_strength'];
        $as = $simulation->result_details['away_strength'];
    @endphp
    <div class="section">
        <div class="section-title">Análisis de fuerza</div>
        <div class="strength-row">
            <span class="strength-label">Categoría</span>
            <span class="strength-home">{{ $simulation->homeTeam->abbreviation }}</span>
            <span class="strength-away">{{ $simulation->awayTeam->abbreviation }}</span>
        </div>
        <div class="strength-row">
            <span class="strength-label">⚔️ Ataque</span>
            <span class="strength-home">{{ $hs['offense'] }}</span>
            <span class="strength-away">{{ $as['offense'] }}</span>
        </div>
        <div class="strength-row">
            <span class="strength-label">🛡️ Defensa</span>
            <span class="strength-home">{{ $hs['defense'] }}</span>
            <span class="strength-away">{{ $as['defense'] }}</span>
        </div>
        <div class="strength-row">
            <span class="strength-label">🎯 Juego en equipo</span>
            <span class="strength-home">{{ $hs['playmaker'] }}</span>
            <span class="strength-away">{{ $as['playmaker'] }}</span>
        </div>
        <div class="strength-row">
            <span class="strength-label">💪 Fuerza total</span>
            <span class="strength-home">{{ $hs['total'] }}</span>
            <span class="strength-away">{{ $as['total'] }}</span>
        </div>
    </div>
    @endif

    {{-- FOOTER --}}
    <div class="footer">
        NBA Simulator · TFG DAW · David Del Coto Ramón · {{ date('Y') }}<br>
        Simulación generada el {{ $simulation->created_at->format('d/m/Y \a \l\a\s H:i') }}
    </div>

</body>
</html>