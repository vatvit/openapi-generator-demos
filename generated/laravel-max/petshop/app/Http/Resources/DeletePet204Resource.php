<?php

declare(strict_types=1);

namespace PetshopApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class DeletePet204Resource extends JsonResource
{
    protected int $httpCode = 204;

    /** @return array<string, mixed> */
    public function toArray($request): array
    {
        /** @var mixed|null $model */
        $model = $this->resource;

        // Handle null resource (empty response or error response)
        if ($model === null) {
            return [];
        }

        return [
        ];
    }

    public function withResponse($request, \Illuminate\Http\JsonResponse $response): void
    {
        // Set hardcoded HTTP 204 status
        $response->setStatusCode($this->httpCode);

    }
}
