<?php

declare(strict_types=1);

namespace PetshopApi\Api\Response;

/**
 * ConflictErrorResponse
 *
 * Error response DTO for HTTP 409 (Conflict)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class ConflictErrorResponse
{
    private int $statusCode = 409;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private string $message = 'The request conflicts with current state',
        private string $code = 'CONFLICT',
    ) {}

    public static function create(
        string $message = 'The request conflicts with current state',
        string $code = 'CONFLICT'
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
