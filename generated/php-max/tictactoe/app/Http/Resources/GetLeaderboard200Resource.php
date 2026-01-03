<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use TictactoeApi\Model\Leaderboard;

final class GetLeaderboard200Resource extends JsonResource
{
    protected int $httpCode = 200;

    /** @return array<string, mixed> */
    public function toArray($request): array
    {
        /** @var Leaderboard|null $model */
        $model = $this->resource;

        // Handle null resource (empty response or error response)
        if ($model === null) {
            return [];
        }

        return [
            'timeframe' => $model->timeframe,
            'entries' => $model->entries,
            'generatedAt' => $model->generatedAt,
        ];
    }

    public function withResponse($request, \Illuminate\Http\JsonResponse $response): void
    {
        // Set hardcoded HTTP 200 status
        $response->setStatusCode($this->httpCode);

    }
}
