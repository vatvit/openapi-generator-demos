<?php declare(strict_types=1);

namespace TictactoeApi\Http\Resources;

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
            'message' => $this->resource['message'] ?? 'Access denied',
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
        $response->setStatusCode($this->httpCode);
    }

    /**
     * Create error resource with message
     *
     * @param string $message Error message
     * @param string|null $code Error code (optional)
     * @return static
     */
    public static function error(string $message, ?string $code = null): static
    {
        return new static([
            'message' => $message,
            'code' => $code ?? 'FORBIDDEN',
        ]);
    }
}
