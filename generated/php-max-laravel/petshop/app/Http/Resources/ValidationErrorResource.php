<?php

declare(strict_types=1);

namespace PetshopApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * ValidationErrorResource
 *
 * Auto-generated Laravel Resource from OpenAPI schema: ValidationError
 * Enforces 422 Unprocessable Entity error response structure
 *
 * PSR-4 COMPLIANT: One class per file
 */
class ValidationErrorResource extends JsonResource
{
    /**
     * HTTP status code for this response
     * Hardcoded: 422 Unprocessable Entity
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
            'error' => 'Unprocessable Entity',
            'message' => $this->resource['message'] ?? 'Validation failed',
            'code' => $this->resource['code'] ?? 'VALIDATION',
            'errors' => $this->resource['errors'] ?? [],
        ];
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP 422 status code
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\JsonResponse  $response
     * @return void
     */
    public function withResponse($request, \Illuminate\Http\JsonResponse $response): void
    {
        $response->setStatusCode($this->httpCode);
    }

    /**
     * Create error resource with message
     *
     * @param string $message Error message
     * @param string|null $code Error code (optional)
     * @return self
     */
    public static function error(string $message, ?string $code = null): self
    {
        return new self([
            'message' => $message,
            'code' => $code ?? 'VALIDATION',
        ]);
    }
}
