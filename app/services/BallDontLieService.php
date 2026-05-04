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
        $this->apiKey = config('services.balldontlie.key');
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
        $response = $this->get('/players', [
            'page'     => $page,
            'per_page' => $perPage,
        ]);
        return $response;
    }

    public function getPlayerStatsBySeason(int $season, int $page = 1): array
    {
        $response = $this->get('/season_averages', [
            'season' => $season,
            'page'   => $page,
        ]);
        return $response;
    }

    public function getPlayerStats(int $playerId, int $season): array
    {
        $response = $this->get('/season_averages', [
            'season'     => $season,
            'player_ids[]' => $playerId,
        ]);
        return $response['data'][0] ?? [];
    }
}