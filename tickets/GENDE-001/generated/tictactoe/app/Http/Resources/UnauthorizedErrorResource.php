<?php declare(strict_types=1);

namespace TictactoeApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * UnauthorizedErrorResource
 *
 * Auto-generated Laravel Resource from OpenAPI schema: UnauthorizedError
 * Enforces 401 Unauthorized error response structure
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
     */
    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->httpCode);
    }

    /**
     * Create error resource with message
     *
     * @param string $message Error message
     * @param string|null $code Error code (optional)
     * @return static
     */
    public static function error(string $message): static
    {
        return new static([
            'message' => $message,
        ]);
    }
}
