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

        $page    = 1;
        $total   = 0;

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

            // Respeta el rate limit de la API
            usleep(300000); // 0.3 segundos

        } while (isset($meta['next_cursor']));

        $this->info("✅ {$total} jugadores sincronizados.");

        // Sincronizar estadísticas
        $this->info("Sincronizando estadísticas temporada {$season}...");
        $this->syncStats($api, $season);
    }

    private function syncStats(BallDontLieService $api, int $season): void
    {
        $page  = 1;
        $total = 0;

        do {
            $response = $api->getPlayerStatsBySeason($season, $page);
            $stats    = $response['data'] ?? [];
            $meta     = $response['meta'] ?? [];

            if (empty($stats)) break;

            foreach ($stats as $stat) {
                $player = Player::where('api_id', $stat['player_id'])->first();
                if (!$player) continue;

                PlayerStat::updateOrCreate(
                    ['player_id' => $player->id, 'season' => $season],
                    [
                        'games_played' => $stat['games_played'] ?? 0,
                        'pts'          => $stat['pts'] ?? 0,
                        'reb'          => $stat['reb'] ?? 0,
                        'ast'          => $stat['ast'] ?? 0,
                        'stl'          => $stat['stl'] ?? 0,
                        'blk'          => $stat['blk'] ?? 0,
                        'fg_pct'       => $stat['fg_pct'] ?? 0,
                        'fg3_pct'      => $stat['fg3_pct'] ?? 0,
                        'ft_pct'       => $stat['ft_pct'] ?? 0,
                        'min'          => $stat['min'] ?? 0,
                        'turnover'     => $stat['turnover'] ?? 0,
                    ]
                );
                $total++;
            }

            $page++;
            usleep(300000);

        } while (isset($meta['next_cursor']));

        $this->info("✅ {$total} estadísticas sincronizadas.");
    }
}