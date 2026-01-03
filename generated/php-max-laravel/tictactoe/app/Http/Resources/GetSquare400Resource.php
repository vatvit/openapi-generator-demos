<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use TictactoeApi\Model\BadRequestError;

final class GetSquare400Resource extends JsonResource
{
    protected int $httpCode = 400;

    /** @return array<string, mixed> */
    public function toArray($request): array
    {
        /** @var BadRequestError|null $model */
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
        // Set hardcoded HTTP 400 status
        $response->setStatusCode($this->httpCode);

    }
}
