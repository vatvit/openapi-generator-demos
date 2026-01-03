<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use TictactoeApi\Model\Status;

final class PutSquare200Resource extends JsonResource
{
    protected int $httpCode = 200;

    /** @return array<string, mixed> */
    public function toArray($request): array
    {
        /** @var Status|null $model */
        $model = $this->resource;

        // Handle null resource (empty response or error response)
        if ($model === null) {
            return [];
        }

        return [
            'winner' => $model->winner,
            'board' => $model->board,
        ];
    }

    public function withResponse($request, \Illuminate\Http\JsonResponse $response): void
    {
        // Set hardcoded HTTP 200 status
        $response->setStatusCode($this->httpCode);

    }
}
