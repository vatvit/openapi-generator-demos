<?php

declare(strict_types=1);

namespace PetshopApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use PetshopApi\Model\Error;

final class AddPet0Resource extends JsonResource
{
    protected int $httpCode = 0;

    /** @return array<string, mixed> */
    public function toArray($request): array
    {
        /** @var Error|null $model */
        $model = $this->resource;

        // Handle null resource (empty response or error response)
        if ($model === null) {
            return [];
        }

        return [
            'code' => $model->code,
            'message' => $model->message,
        ];
    }

    public function withResponse($request, \Illuminate\Http\JsonResponse $response): void
    {
        // Set hardcoded HTTP 0 status
        $response->setStatusCode($this->httpCode);

    }
}
