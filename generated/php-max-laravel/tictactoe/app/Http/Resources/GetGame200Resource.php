<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use TictactoeApi\Model\Game;

final class GetGame200Resource extends JsonResource
{
    protected int $httpCode = 200;

    /** @return array<string, mixed> */
    public function toArray($request): array
    {
        /** @var Game|null $model */
        $model = $this->resource;

        // Handle null resource (empty response or error response)
        if ($model === null) {
            return [];
        }

        return [
            'id' => $model->id,
            'status' => $model->status,
            'mode' => $model->mode,
            'board' => $model->board,
            'createdAt' => $model->createdAt,
            'playerX' => $model->playerX,
            'playerO' => $model->playerO,
            'currentTurn' => $model->currentTurn,
            'winner' => $model->winner,
            'updatedAt' => $model->updatedAt,
            'completedAt' => $model->completedAt,
        ];
    }

    public function withResponse($request, \Illuminate\Http\JsonResponse $response): void
    {
        // Set hardcoded HTTP 200 status
        $response->setStatusCode($this->httpCode);

    }
}
