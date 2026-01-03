<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

/**
 * ForbiddenErrorResponse
 *
 * Error response DTO for HTTP 403 (Forbidden)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class ForbiddenErrorResponse
{
    private int $statusCode = 403;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private string $message = 'Access denied',
        private string $code = 'FORBIDDEN',
    ) {}

    public static function create(
        string $message = 'Access denied',
        string $code = 'FORBIDDEN'
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
