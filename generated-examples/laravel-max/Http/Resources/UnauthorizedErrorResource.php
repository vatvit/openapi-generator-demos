<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * UnauthorizedErrorResource
 *
 * Auto-generated Laravel Resource from OpenAPI schema: UnauthorizedError
 * Enforces 401 unauthorized error response structure
 *
 * PSR-4 COMPLIANT: One class per file
 */
class UnauthorizedErrorResource extends JsonResource
{
    /**
     * HTTP status code for this response
     * Hardcoded: 401 Unauthorized
     *
     * @var int
     */
    protected int $httpCode = 401;

    /**
     * Transform the resource into an array.
     *
     * Structure enforced by OpenAPI schema: UnauthorizedError
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'error' => 'Unauthorized',
            'message' => $this->resource['message'] ?? 'Authentication required',
        ];
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP 401 status code
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     * @throws \RuntimeException if httpCode not set
     */
    public function withResponse($request, $response)
    {
        // Set hardcoded HTTP 401 status
        $response->setStatusCode($this->httpCode);

        // UnauthorizedError has no special headers
    }
}
