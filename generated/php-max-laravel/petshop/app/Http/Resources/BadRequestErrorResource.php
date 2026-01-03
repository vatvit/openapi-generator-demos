<?php

declare(strict_types=1);

namespace PetshopApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * BadRequestErrorResource
 *
 * Auto-generated Laravel Resource from OpenAPI schema: BadRequestError
 * Enforces 400 Bad Request error response structure
 *
 * PSR-4 COMPLIANT: One class per file
 */
class BadRequestErrorResource extends JsonResource
{
    /**
     * HTTP status code for this response
     * Hardcoded: 400 Bad Request
     *
     * @var int
     */
    protected int $httpCode = 400;

    /**
     * Transform the resource into an array.
     *
     * Structure enforced by OpenAPI schema: BadRequestError
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'error' => 'Bad Request',
            'message' => $this->resource['message'] ?? 'The request was invalid',
            'code' => $this->resource['code'] ?? 'BADREQUEST',
        ];
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP 400 status code
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
            'code' => $code ?? 'BADREQUEST',
        ]);
    }
}
