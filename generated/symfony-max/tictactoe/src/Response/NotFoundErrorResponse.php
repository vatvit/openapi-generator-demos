<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

/**
 * NotFoundErrorResponse
 *
 * Error response DTO for HTTP 404 (Not Found)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class NotFoundErrorResponse
{
    private int $statusCode = 404;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private string $message = 'The requested resource was not found',
        private string $code = 'NOTFOUND',
    ) {}

    public static function create(
        string $message = 'The requested resource was not found',
        string $code = 'NOTFOUND'
    ): self {
        return new self($message, $code);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /** @return array<string, mixed> */
    public function getData(): array
    {
        return [
            'message' => $this->message,
            'code' => $this->code,
        ];
    }

    /** @return array<string, string> */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function withHeader(string $name, string $value): self
    {
        $clone = clone $this;
        $clone->headers[$name] = $value;
        return $clone;
    }
}
