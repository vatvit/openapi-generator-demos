<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * NotFoundErrorResource
 *
 * Auto-generated Laravel Resource from OpenAPI schema: NotFoundError
 * Enforces 404 Not Found error response structure
 *
 * PSR-4 COMPLIANT: One class per file
 */
class NotFoundErrorResource extends JsonResource
{
    /**
     * HTTP status code for this response
     * Hardcoded: 404 Not Found
     *
     * @var int
     */
    protected int $httpCode = 404;

    /**
     * Transform the resource into an array.
     *
     * Structure enforced by OpenAPI schema: NotFoundError
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'error' => 'Not Found',
            'message' => $this->resource['message'] ?? 'The requested resource was not found',
            'code' => $this->resource['code'] ?? 'NOT_FOUND',
        ];
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP 404 status code
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        // Set hardcoded HTTP 404 status
        $response->setStatusCode($this->httpCode);
    }
}
