<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * ForbiddenErrorResource
 *
 * Auto-generated Laravel Resource from OpenAPI schema: ForbiddenError
 * Enforces 403 Forbidden error response structure
 *
 * PSR-4 COMPLIANT: One class per file
 */
class ForbiddenErrorResource extends JsonResource
{
    /**
     * HTTP status code for this response
     * Hardcoded: 403 Forbidden
     *
     * @var int
     */
    protected int $httpCode = 403;

    /**
     * Transform the resource into an array.
     *
     * Structure enforced by OpenAPI schema: ForbiddenError
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'error' => 'Forbidden',
            'message' => $this->resource['message'] ?? 'You do not have permission to access this resource',
            'code' => $this->resource['code'] ?? 'FORBIDDEN',
        ];
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP 403 status code
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        // Set hardcoded HTTP 403 status
        $response->setStatusCode($this->httpCode);
    }
}
