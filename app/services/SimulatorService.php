<?php

namespace App\Services;

use App\Models\Team;
use App\Models\Player;

class SimulatorService
{
    // Factor de ventaja local (6% más de fuerza al equipo local)
    private float $homeFactor = 1.06;

    // Penalización por lesión según el estado del jugador
    private array $injuryPenalty = [
        'out'          => 0.0,   // No juega, aportación 0%
        'questionable' => 0.5,   // Juega al 50% de su rendimiento
        'day-to-day'   => 0.75,  // Juega al 75% de su rendimiento
    ];

    /**
     * Método principal que orquesta la simulación completa de un partido.
     * Recibe los dos equipos y devuelve un array con todos los datos del resultado.
     */
    public function simulate(Team $home, Team $away): array
    {
        // Obtener los 5 jugadores clave de cada equipo
        $homePlayers = $this->getKeyPlayers($home);
        $awayPlayers = $this->getKeyPlayers($away);

        // Calcular la fuerza de cada equipo basándose en sus jugadores
        $homeStrength = $this->calculateStrength($homePlayers, true);
        $awayStrength = $this->calculateStrength($awayPlayers, false);

        // Obtener el informe de lesiones de cada equipo
        $homeInjuryReport = $this->getInjuryReport($homePlayers);
        $awayInjuryReport = $this->getInjuryReport($awayPlayers);

        // Calcular probabilidades de victoria basadas en la fuerza total
        $total       = $homeStrength['total'] + $awayStrength['total'];
        $homeWinProb = round(($homeStrength['total'] / $total) * 100, 1);
        $awayWinProb = round(100 - $homeWinProb, 1);

        // Generar los parciales por cuarto y calcular marcador final
        $quarters  = $this->generateQuarters($homeStrength, $awayStrength);
        $homeScore = array_sum($quarters['home']);
        $awayScore = array_sum($quarters['away']);

        // Si el favorito pierde en el marcador, intercambiar los marcadores
        if ($homeWinProb > $awayWinProb && $homeScore < $awayScore) {
            [$quarters['home'], $quarters['away']] = [$quarters['away'], $quarters['home']];
            [$homeScore, $awayScore] = [$awayScore, $homeScore];
        }

        return [
            'home_team'          => $home,
            'away_team'          => $away,
            'home_win_prob'      => $homeWinProb,
            'away_win_prob'      => $awayWinProb,
            'home_score'         => $homeScore,
            'away_score'         => $awayScore,
            'quarters'           => $quarters,
            'home_strength'      => $homeStrength,
            'away_strength'      => $awayStrength,
            'home_injury_report' => $homeInjuryReport,
            'away_injury_report' => $awayInjuryReport,
            'home_players'       => $homePlayers,
            'away_players'       => $awayPlayers,
            'winner'             => $homeWinProb >= $awayWinProb ? $home : $away,
        ];
    }

    /**
     * Obtiene los 5 jugadores más importantes del equipo
     * ordenados por puntos por partido (mayor anotador primero).
     */
    private function getKeyPlayers(Team $team): \Illuminate\Support\Collection
    {
        return Player::with(['currentStats', 'activeInjury'])
            ->where('team_id', $team->id)
            ->whereHas('currentStats')
            ->get()
            ->sortByDesc(fn($p) => $p->currentStats->pts ?? 0)
            ->take(5);
    }

    /**
     * Calcula la fuerza total de un equipo en base a tres partes:
     * - Ataque: puntos anotados + porcentaje de triples
     * - Defensa: robos + tapones + rebotes
     * - Juego en equipo: asistencias
     * Aplica la ventaja local si corresponde.
     */
    private function calculateStrength(\Illuminate\Support\Collection $players, bool $isHome): array
    {
        $offenseScore   = 0;
        $defenseScore   = 0;
        $playmakerScore = 0;
        $details        = [];

        foreach ($players as $player) {
            $stats  = $player->currentStats;
            $factor = $this->getInjuryFactor($player);

            // Puntuación ofensiva: puntos + contribución de triples
            $offense = ($stats->pts * 1.0 + $stats->fg3_pct * 20) * $factor;

            // Puntuación defensiva: robos y tapones tienen más peso que rebotes
            $defense = ($stats->stl * 3 + $stats->blk * 3 + $stats->reb * 0.5) * $factor;

            // Puntuación de juego en equipo: asistencias
            $playmaker = ($stats->ast * 2) * $factor;

            $offenseScore   += $offense;
            $defenseScore   += $defense;
            $playmakerScore += $playmaker;

            // Guardar detalle individual para mostrarlo en la vista
            $details[] = [
                'player'    => $player,
                'factor'    => $factor,
                'offense'   => round($offense, 2),
                'defense'   => round($defense, 2),
                'playmaker' => round($playmaker, 2),
                'injured'   => $player->activeInjury !== null,
            ];
        }

        // Suma total de las tres partes
        $total = $offenseScore + $defenseScore + $playmakerScore;

        // Aplicar ventaja local del 6% al equipo de casa
        if ($isHome) $total *= $this->homeFactor;

        return [
            'offense'   => round($offenseScore, 2),
            'defense'   => round($defenseScore, 2),
            'playmaker' => round($playmakerScore, 2),
            'total'     => round($total, 2),
            'details'   => $details,
        ];
    }

    /**
     * Genera los puntos de cada cuarto para ambos equipos.
     * Los puntos base se calculan a partir de la fuerza ofensiva del equipo
     */
    private function generateQuarters(array $homeStrength, array $awayStrength): array
    {
        $homeQuarters = [];
        $awayQuarters = [];

        // Calcular base de puntos por cuarto a partir de la fuerza ofensiva
        $homeBase = ($homeStrength['offense'] / 5) + rand(-3, 3);
        $awayBase = ($awayStrength['offense'] / 5) + rand(-3, 3);

        // Limitar a un rango realista de puntos por cuarto en la NBA (15-40)
        $homeBase = max(15, min(40, $homeBase));
        $awayBase = max(15, min(40, $awayBase));

        // Generar los 4 cuartos con variación aleatoria
        for ($q = 1; $q <= 4; $q++) {
            $homeQuarters[] = (int) round($homeBase + rand(-4, 4));
            $awayQuarters[] = (int) round($awayBase + rand(-4, 4));
        }

        $homeTotal = array_sum($homeQuarters);
        $awayTotal = array_sum($awayQuarters);

        // Evitar empates — en la NBA no existe el empate
        // Si empatan, el favorito gana el último cuarto con puntos extra
        if ($homeTotal === $awayTotal) {
            if ($homeStrength['total'] >= $awayStrength['total']) {
                $homeQuarters[3] += rand(2, 6); // El local gana en prórroga
            } else {
                $awayQuarters[3] += rand(2, 6); // El visitante gana en prórroga
            }
        }

        return [
            'home' => $homeQuarters,
            'away' => $awayQuarters,
        ];
    }

    /**
     * Devuelve el factor de rendimiento de un jugador según su estado de lesión.
     * Si está sano devuelve 1.0 (rendimiento completo).
     */
    private function getInjuryFactor(Player $player): float
    {
        if (!$player->activeInjury) return 1.0;
        return $this->injuryPenalty[$player->activeInjury->status] ?? 0.5;
    }

    /**
     * Genera el informe de lesiones de un equipo.
     * Solo incluye jugadores que tienen una lesión activa.
     */
    private function getInjuryReport(\Illuminate\Support\Collection $players): array
    {
        $report = [];
        foreach ($players as $player) {
            if ($player->activeInjury) {
                $report[] = [
                    'player' => $player,
                    'injury' => $player->activeInjury,
                    'factor' => $this->getInjuryFactor($player),
                ];
            }
        }
        return $report;
    }
}