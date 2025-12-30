<?php declare(strict_types=1);

namespace TictactoeApi\Http\Resources;

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
            'code' => $this->resource['code'] ?? 'NOTFOUND',
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
            'code' => $code ?? 'NOTFOUND',
        ]);
    }
}
