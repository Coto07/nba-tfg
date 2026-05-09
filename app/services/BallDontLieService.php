<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BallDontLieService
{
    private string $baseUrl = 'https://api.balldontlie.io/v1';
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('BALLDONTLIE_API_KEY');
    }

    private function get(string $endpoint, array $params = []): array
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
        ])->get($this->baseUrl . $endpoint, $params);

        if ($response->failed()) {
            Log::error('BallDontLie API error', [
                'endpoint' => $endpoint,
                'status'   => $response->status(),
                'body'     => $response->body()
            ]);
            return [];
        }

        return $response->json() ?? [];
    }

    public function getTeams(): array
    {
        $response = $this->get('/teams');
        return $response['data'] ?? [];
    }

    public function getPlayers(int $page = 1, int $perPage = 100): array
    {
        return $this->get('/players', [
            'page'     => $page,
            'per_page' => $perPage,
        ]);
    }

    public function getStatsByPlayer(int $playerId, int $season): array
    {
        $response = $this->get('/stats', [
            'player_ids[]' => $playerId,
            'seasons[]'    => $season,
            'per_page'     => 100,
        ]);
        return $response['data'] ?? [];
    }

    public function getTodayGames(): array
{
    $response = $this->get('/games', [
        'dates[]'  => date('Y-m-d'),
        'per_page' => 15,
    ]);
    return $response['data'] ?? [];
}
}