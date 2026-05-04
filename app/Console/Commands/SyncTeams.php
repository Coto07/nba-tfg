<?php

namespace App\Console\Commands;

use App\Models\Team;
use App\Services\BallDontLieService;
use Illuminate\Console\Command;

class SyncTeams extends Command
{
    protected $signature   = 'nba:sync-teams';
    protected $description = 'Sincroniza los equipos de la NBA desde la API';

    public function handle(BallDontLieService $api): void
    {
        $this->info('Sincronizando equipos...');

        $teams = $api->getTeams();

        if (empty($teams)) {
            $this->error('No se pudieron obtener equipos de la API.');
            return;
        }

        $count = 0;
        foreach ($teams as $teamData) {
            Team::updateOrCreate(
                ['api_id' => $teamData['id']],
                [
                    'name'         => $teamData['name'],
                    'city'         => $teamData['city'],
                    'abbreviation' => $teamData['abbreviation'],
                    'conference'   => $teamData['conference'] ?? null,
                    'division'     => $teamData['division'] ?? null,
                    'full_name'    => $teamData['full_name'] ?? $teamData['city'] . ' ' . $teamData['name'],
                ]
            );
            $count++;
        }

        $this->info("✅ {$count} equipos sincronizados correctamente.");
    }
}