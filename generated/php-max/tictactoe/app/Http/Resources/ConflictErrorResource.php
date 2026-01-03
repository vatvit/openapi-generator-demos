<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * ConflictErrorResource
 *
 * Auto-generated Laravel Resource from OpenAPI schema: ConflictError
 * Enforces 409 Conflict error response structure
 *
 * PSR-4 COMPLIANT: One class per file
 */
class ConflictErrorResource extends JsonResource
{
    /**
     * HTTP status code for this response
     * Hardcoded: 409 Conflict
     *
     * @var int
     */
    protected int $httpCode = 409;

    /**
     * Transform the resource into an array.
     *
     * Structure enforced by OpenAPI schema: ConflictError
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'error' => 'Conflict',
            'message' => $this->resource['message'] ?? 'The request conflicts with current state',
            'code' => $this->resource['code'] ?? 'CONFLICT',
        ];
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP 409 status code
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
            'code' => $code ?? 'CONFLICT',
        ]);
    }
}
