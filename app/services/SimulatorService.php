<?php

namespace App\Services;

use App\Models\Team;
use App\Models\Player;

class SimulatorService
{
    private float $homeFactor = 1.06;

    private array $injuryPenalty = [
        'out'          => 0.0,
        'questionable' => 0.5,
        'day-to-day'   => 0.75,
    ];

    public function simulate(Team $home, Team $away): array
    {
        $homePlayers = $this->getKeyPlayers($home);
        $awayPlayers = $this->getKeyPlayers($away);

        $homeStrength = $this->calculateStrength($homePlayers, true);
        $awayStrength = $this->calculateStrength($awayPlayers, false);

        $homeInjuryReport = $this->getInjuryReport($homePlayers);
        $awayInjuryReport = $this->getInjuryReport($awayPlayers);

        $total       = $homeStrength['total'] + $awayStrength['total'];
        $homeWinProb = round(($homeStrength['total'] / $total) * 100, 1);
        $awayWinProb = round(100 - $homeWinProb, 1);

        // Generar parciales por cuarto
        $quarters    = $this->generateQuarters($homeStrength, $awayStrength);
        $homeScore   = array_sum($quarters['home']);
        $awayScore   = array_sum($quarters['away']);

        // Asegurar que el favorito gana
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
        $offenseScore   = 0;
        $defenseScore   = 0;
        $playmakerScore = 0;
        $details        = [];

        foreach ($players as $player) {
            $stats  = $player->currentStats;
            $factor = $this->getInjuryFactor($player);

            $offense   = ($stats->pts * 1.0 + $stats->fg3_pct * 20) * $factor;
            $defense   = ($stats->stl * 3 + $stats->blk * 3 + $stats->reb * 0.5) * $factor;
            $playmaker = ($stats->ast * 2) * $factor;

            $offenseScore   += $offense;
            $defenseScore   += $defense;
            $playmakerScore += $playmaker;

            $details[] = [
                'player'    => $player,
                'factor'    => $factor,
                'offense'   => round($offense, 2),
                'defense'   => round($defense, 2),
                'playmaker' => round($playmaker, 2),
                'injured'   => $player->activeInjury !== null,
            ];
        }

        $total = $offenseScore + $defenseScore + $playmakerScore;
        if ($isHome) $total *= $this->homeFactor;

        return [
            'offense'   => round($offenseScore, 2),
            'defense'   => round($defenseScore, 2),
            'playmaker' => round($playmakerScore, 2),
            'total'     => round($total, 2),
            'details'   => $details,
        ];
    }

    private function generateQuarters(array $homeStrength, array $awayStrength): array
    {
        $homeQuarters = [];
        $awayQuarters = [];

        // Base de puntos por cuarto (partido NBA = ~105-115 pts)
        $homeBase = ($homeStrength['offense'] / 5) + rand(-3, 3);
        $awayBase = ($awayStrength['offense'] / 5) + rand(-3, 3);

        // Normalizar a rango realista (22-32 pts por cuarto)
        $homeBase = max(22, min(32, $homeBase));
        $awayBase = max(22, min(32, $awayBase));

        for ($q = 1; $q <= 4; $q++) {
            $homeQuarters[] = (int) round($homeBase + rand(-4, 4));
            $awayQuarters[] = (int) round($awayBase + rand(-4, 4));
        }

        return [
            'home' => $homeQuarters,
            'away' => $awayQuarters,
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
}
