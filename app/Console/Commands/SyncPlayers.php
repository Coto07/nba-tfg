<?php

namespace App\Console\Commands;

use App\Models\Player;
use App\Models\PlayerStat;
use App\Models\Team;
use App\Services\BallDontLieService;
use Illuminate\Console\Command;

class SyncPlayers extends Command
{
    protected $signature   = 'nba:sync-players {--season=2024}';
    protected $description = 'Sincroniza jugadores y sus estadísticas desde la API';

    public function handle(BallDontLieService $api): void
    {
        $season = (int) $this->option('season');
        $this->info("Sincronizando jugadores temporada {$season}...");

        $page  = 1;
        $total = 0;

        do {
            $response = $api->getPlayers($page, 100);
            $players  = $response['data'] ?? [];
            $meta     = $response['meta'] ?? [];

            if (empty($players)) break;

            foreach ($players as $p) {
                $team = isset($p['team']['id'])
                    ? Team::where('api_id', $p['team']['id'])->first()
                    : null;

                Player::updateOrCreate(
                    ['api_id' => $p['id']],
                    [
                        'team_id'       => $team?->id,
                        'first_name'    => $p['first_name'],
                        'last_name'     => $p['last_name'],
                        'position'      => $p['position'] ?? null,
                        'jersey_number' => $p['jersey_number'] ?? null,
                        'height'        => $p['height'] ?? null,
                        'weight'        => $p['weight'] ?? null,
                        'college'       => $p['college'] ?? null,
                        'country'       => $p['country'] ?? null,
                    ]
                );
                $total++;
            }

            $this->info("  Página {$page} procesada ({$total} jugadores)...");
            $page++;
            usleep(300000);

        } while (isset($meta['next_cursor']));

        $this->info("✅ {$total} jugadores sincronizados.");

        $this->info("Sincronizando estadísticas temporada {$season}...");
        $this->syncStats($api, $season);
    }

    private function syncStats(BallDontLieService $api, int $season): void
    {
        $total   = 0;
        $players = Player::whereNotNull('team_id')->get();

        foreach ($players as $player) {
            $stats = $api->getStatsByPlayer($player->api_id, $season);

            if (empty($stats)) {
                usleep(200000);
                continue;
            }

            // Calcular promedios manualmente
            $games    = count($stats);
            $pts      = collect($stats)->avg('pts') ?? 0;
            $reb      = collect($stats)->avg('reb') ?? 0;
            $ast      = collect($stats)->avg('ast') ?? 0;
            $stl      = collect($stats)->avg('stl') ?? 0;
            $blk      = collect($stats)->avg('blk') ?? 0;
            $fg_pct   = collect($stats)->avg('fg_pct') ?? 0;
            $fg3_pct  = collect($stats)->avg('fg3_pct') ?? 0;
            $ft_pct   = collect($stats)->avg('ft_pct') ?? 0;
            $turnover = collect($stats)->avg('turnover') ?? 0;

            // Calcular minutos promedio
            $minutes = collect($stats)->map(function ($s) {
                if (empty($s['min'])) return 0;
                $parts = explode(':', $s['min']);
                return isset($parts[1])
                    ? (int)$parts[0] + ((int)$parts[1] / 60)
                    : (float)$parts[0];
            })->avg();

            PlayerStat::updateOrCreate(
                ['player_id' => $player->id, 'season' => $season],
                [
                    'games_played' => $games,
                    'pts'          => round($pts, 2),
                    'reb'          => round($reb, 2),
                    'ast'          => round($ast, 2),
                    'stl'          => round($stl, 2),
                    'blk'          => round($blk, 2),
                    'fg_pct'       => round($fg_pct, 4),
                    'fg3_pct'      => round($fg3_pct, 4),
                    'ft_pct'       => round($ft_pct, 4),
                    'min'          => round($minutes, 2),
                    'turnover'     => round($turnover, 2),
                ]
            );

            $total++;
            $this->info("  ✅ {$player->first_name} {$player->last_name} ({$games} partidos)");
            usleep(300000);
        }

        $this->info("✅ {$total} estadísticas sincronizadas.");
    }
}