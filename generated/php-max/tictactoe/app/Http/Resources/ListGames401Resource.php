<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use TictactoeApi\Model\UnauthorizedError;

final class ListGames401Resource extends JsonResource
{
    protected int $httpCode = 401;

    /** @return array<string, mixed> */
    public function toArray($request): array
    {
        /** @var UnauthorizedError|null $model */
        $model = $this->resource;

        // Handle null resource (empty response or error response)
        if ($model === null) {
            return [];
        }

        return [
            'code' => $model->code,
            'message' => $model->message,
            'details' => $model->details,
            'errorType' => $model->errorType,
        ];
    }

    public function withResponse($request, \Illuminate\Http\JsonResponse $response): void
    {
        // Set hardcoded HTTP 401 status
        $response->setStatusCode($this->httpCode);

    }
}
