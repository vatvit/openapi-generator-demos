<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * ValidationErrorResource
 *
 * Auto-generated Laravel Resource from OpenAPI schema: ValidationError
 * Enforces 422 validation error response structure
 *
 * PSR-4 COMPLIANT: One class per file
 */
class ValidationErrorResource extends JsonResource
{
    /**
     * HTTP status code for this response
     * MUST be set by Handler
     *
     * @var int
     */
    public int $httpCode;

    /**
     * Transform the resource into an array.
     *
     * Structure enforced by OpenAPI schema: ValidationError
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'error' => 'Validation Error',
            'message' => $this->resource['message'] ?? 'The request data is invalid',
            'errors' => $this->resource['errors'] ?? [],
        ];
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP 422 status code
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     * @throws \RuntimeException if httpCode not set
     */
    public function withResponse($request, $response)
    {
        // Enforce HTTP status code is set
        if (!isset($this->httpCode)) {
            throw new \RuntimeException('HTTP status code not set for ValidationErrorResource. Handler must set $resource->httpCode');
        }

        $response->setStatusCode($this->httpCode);

        // ValidationError has no special headers
    }
}
