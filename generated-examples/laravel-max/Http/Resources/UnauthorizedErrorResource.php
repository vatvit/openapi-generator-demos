<?php

declare(strict_types=1);

namespace App\Http\Resources;

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
     * MUST be set by Handler
     *
     * @var int
     */
    public int $httpCode;

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
        // Enforce HTTP status code is set
        if (!isset($this->httpCode)) {
            throw new \RuntimeException('HTTP status code not set for UnauthorizedErrorResource. Handler must set $resource->httpCode');
        }

        $response->setStatusCode($this->httpCode);

        // UnauthorizedError has no special headers
    }
}
