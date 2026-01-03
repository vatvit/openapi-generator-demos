<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use TictactoeApi\Model\ValidationError;

final class CreateGame422Resource extends JsonResource
{
    protected int $httpCode = 422;

    /** @return array<string, mixed> */
    public function toArray($request): array
    {
        /** @var ValidationError|null $model */
        $model = $this->resource;

        // Handle null resource (empty response or error response)
        if ($model === null) {
            return [];
        }

        return [
            'code' => $model->code,
            'message' => $model->message,
            'errors' => $model->errors,
            'details' => $model->details,
        ];
    }

    public function withResponse($request, \Illuminate\Http\JsonResponse $response): void
    {
        // Set hardcoded HTTP 422 status
        $response->setStatusCode($this->httpCode);

    }
}
