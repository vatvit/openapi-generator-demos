<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use TictactoeApi\Model\PlayerStats;

final class GetPlayerStats200Resource extends JsonResource
{
    protected int $httpCode = 200;

    /** @return array<string, mixed> */
    public function toArray($request): array
    {
        /** @var PlayerStats|null $model */
        $model = $this->resource;

        // Handle null resource (empty response or error response)
        if ($model === null) {
            return [];
        }

        return [
            'playerId' => $model->playerId,
            'gamesPlayed' => $model->gamesPlayed,
            'wins' => $model->wins,
            'losses' => $model->losses,
            'draws' => $model->draws,
            'player' => $model->player,
            'winRate' => $model->winRate,
            'currentStreak' => $model->currentStreak,
            'longestWinStreak' => $model->longestWinStreak,
        ];
    }

    public function withResponse($request, \Illuminate\Http\JsonResponse $response): void
    {
        // Set hardcoded HTTP 200 status
        $response->setStatusCode($this->httpCode);

    }
}
