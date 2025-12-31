<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Resources;

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
     * Hardcoded: 422 Unprocessable Entity (validation error)
     *
     * @var int
     */
    protected int $httpCode = 422;

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
        // Set hardcoded HTTP 422 status
        $response->setStatusCode($this->httpCode);

        // ValidationError has no special headers
    }
}
