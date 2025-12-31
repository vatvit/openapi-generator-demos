<?php declare(strict_types=1);

namespace TictactoeApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * InternalServerErrorResource
 *
 * Auto-generated Laravel Resource from OpenAPI schema: InternalServerError
 * Enforces 500 Internal Server Error error response structure
 *
 * PSR-4 COMPLIANT: One class per file
 */
class InternalServerErrorResource extends JsonResource
{
    /**
     * HTTP status code for this response
     * Hardcoded: 500 Internal Server Error
     *
     * @var int
     */
    protected int $httpCode = 500;

    /**
     * Transform the resource into an array.
     *
     * Structure enforced by OpenAPI schema: InternalServerError
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'error' => 'Internal Server Error',
            'message' => $this->resource['message'] ?? 'An unexpected error occurred',
            'code' => $this->resource['code'] ?? 'INTERNALSERVER',
        ];
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP 500 status code
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
            'code' => $code ?? 'INTERNALSERVER',
        ]);
    }
}
