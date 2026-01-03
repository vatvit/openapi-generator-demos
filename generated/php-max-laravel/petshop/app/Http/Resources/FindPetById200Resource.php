<?php

declare(strict_types=1);

namespace PetshopApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use PetshopApi\Model\Pet;

final class FindPetById200Resource extends JsonResource
{
    protected int $httpCode = 200;

    /** @return array<string, mixed> */
    public function toArray($request): array
    {
        /** @var Pet|null $model */
        $model = $this->resource;

        // Handle null resource (empty response or error response)
        if ($model === null) {
            return [];
        }

        return [
            'name' => $model->name,
            'id' => $model->id,
            'tag' => $model->tag,
        ];
    }

    public function withResponse($request, \Illuminate\Http\JsonResponse $response): void
    {
        // Set hardcoded HTTP 200 status
        $response->setStatusCode($this->httpCode);

    }
}
