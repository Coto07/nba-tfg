<?php

namespace App\Services;

use App\Models\Team;
use App\Models\Player;
use App\Models\PlayerStat;

class SimulatorService
{
    // Factor de ventaja local
    private float $homeFactor = 1.06;

    // Penalización por lesión según estado
    private array $injuryPenalty = [
        'out'          => 0.0,   // No juega, aportación 0
        'questionable' => 0.5,   // Juega al 50%
        'day-to-day'   => 0.75,  // Juega al 75%
    ];

    public function simulate(Team $home, Team $away): array
    {
        $homePlayers = $this->getKeyPlayers($home);
        $awayPlayers = $this->getKeyPlayers($away);

        $homeStrength = $this->calculateStrength($homePlayers, true);
        $awayStrength = $this->calculateStrength($awayPlayers, false);

        $homeInjuryReport = $this->getInjuryReport($homePlayers);
        $awayInjuryReport = $this->getInjuryReport($awayPlayers);

        // Calcular probabilidades
        $total       = $homeStrength['total'] + $awayStrength['total'];
        $homeWinProb = round(($homeStrength['total'] / $total) * 100, 1);
        $awayWinProb = round(100 - $homeWinProb, 1);

        // Simular marcador estimado
        $homeScore = $this->estimateScore($homePlayers, $awayPlayers);
        $awayScore = $this->estimateScore($awayPlayers, $homePlayers);

        // Ajustar para que el favorito gane si hay diferencia clara
        if ($homeWinProb > $awayWinProb && $homeScore < $awayScore) {
            [$homeScore, $awayScore] = [$awayScore, $homeScore];
        }

        return [
            'home_team'         => $home,
            'away_team'         => $away,
            'home_win_prob'     => $homeWinProb,
            'away_win_prob'     => $awayWinProb,
            'home_score'        => $homeScore,
            'away_score'        => $awayScore,
            'home_strength'     => $homeStrength,
            'away_strength'     => $awayStrength,
            'home_injury_report'=> $homeInjuryReport,
            'away_injury_report'=> $awayInjuryReport,
            'home_players'      => $homePlayers,
            'away_players'      => $awayPlayers,
            'winner'            => $homeWinProb >= $awayWinProb ? $home : $away,
        ];
    }

    private function getKeyPlayers(Team $team): \Illuminate\Support\Collection
    {
        return Player::with(['currentStats', 'activeInjury'])
            ->where('team_id', $team->id)
            ->whereHas('currentStats')
            ->get()
            ->sortByDesc(fn($p) => $p->currentStats->pts ?? 0)
            ->take(5);
    }

    private function calculateStrength(\Illuminate\Support\Collection $players, bool $isHome): array
    {
        $offenseScore  = 0;
        $defenseScore  = 0;
        $playmakerScore = 0;
        $details       = [];

        foreach ($players as $player) {
            $stats  = $player->currentStats;
            $factor = $this->getInjuryFactor($player);

            // Puntuación ofensiva: puntos + triples
            $offense = ($stats->pts * 1.0 + $stats->fg3_pct * 20) * $factor;

            // Puntuación defensiva: robos + tapones + rebotes
            $defense = ($stats->stl * 3 + $stats->blk * 3 + $stats->reb * 0.5) * $factor;

            // Puntuación de juego: asistencias
            $playmaker = ($stats->ast * 2) * $factor;

            $offenseScore   += $offense;
            $defenseScore   += $defense;
            $playmakerScore += $playmaker;

            $details[] = [
                'player'   => $player,
                'factor'   => $factor,
                'offense'  => round($offense, 2),
                'defense'  => round($defense, 2),
                'playmaker'=> round($playmaker, 2),
                'injured'  => $player->activeInjury !== null,
            ];
        }

        $total = $offenseScore + $defenseScore + $playmakerScore;

        // Aplicar ventaja local
        if ($isHome) {
            $total *= $this->homeFactor;
        }

        return [
            'offense'   => round($offenseScore, 2),
            'defense'   => round($defenseScore, 2),
            'playmaker' => round($playmakerScore, 2),
            'total'     => round($total, 2),
            'details'   => $details,
        ];
    }

    private function getInjuryFactor(Player $player): float
    {
        if (!$player->activeInjury) return 1.0;
        return $this->injuryPenalty[$player->activeInjury->status] ?? 0.5;
    }

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

    private function estimateScore(
        \Illuminate\Support\Collection $teamPlayers,
        \Illuminate\Support\Collection $oppPlayers
    ): int {
        $baseScore = 0;

        foreach ($teamPlayers as $player) {
            $stats   = $player->currentStats;
            $factor  = $this->getInjuryFactor($player);
            $baseScore += $stats->pts * $factor;
        }

        // Ajuste defensivo del rival
        $oppDefense = $oppPlayers->sum(fn($p) =>
            (($p->currentStats->stl ?? 0) + ($p->currentStats->blk ?? 0)) *
            $this->getInjuryFactor($p)
        );

        $score = $baseScore - ($oppDefense * 0.5) + rand(-5, 5);

        return max(85, min(140, (int) round($score)));
    }
}