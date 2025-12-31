<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * DeleteGame204Resource
 *
 * Auto-generated Laravel Resource for delete-game operation (HTTP 204)
 * Returns empty body with 204 No Content
 *
 * OpenAPI Operation: delete-game
 * Response: 204 No Content
 * Schema: Empty (no content)
 * Headers: None
 *
 * PSR-4 COMPLIANT: One class per file, one Resource per operation response
 */
class DeleteGame204Resource extends JsonResource
{
    /**
     * HTTP status code for this response
     * Hardcoded: 204 No Content
     *
     * @var int
     */
    protected int $httpCode = 204;

    /**
     * Transform the resource into an array.
     *
     * 204 No Content responses must return empty array
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        // 204 No Content - empty response body
        return [];
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP 204 status code
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        // Set hardcoded HTTP 204 No Content status
        $response->setStatusCode($this->httpCode);

        // 204 responses have no content, so we ensure content is empty
        $response->setContent('');
    }
}
