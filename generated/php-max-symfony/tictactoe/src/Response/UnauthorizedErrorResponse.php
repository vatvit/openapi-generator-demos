<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

/**
 * UnauthorizedErrorResponse
 *
 * Error response DTO for HTTP 401 (Unauthorized)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class UnauthorizedErrorResponse
{
    private int $statusCode = 401;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private string $message = 'Authentication required',
    ) {}

    public static function create(
        string $message = 'Authentication required'
    ): self {
        return new self($message);
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
