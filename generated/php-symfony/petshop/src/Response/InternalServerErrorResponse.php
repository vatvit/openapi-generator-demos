<?php

declare(strict_types=1);

namespace PetshopApi\Api\Response;

/**
 * InternalServerErrorResponse
 *
 * Error response DTO for HTTP 500 (Internal Server Error)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class InternalServerErrorResponse
{
    private int $statusCode = 500;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private string $message = 'An unexpected error occurred',
        private string $code = 'INTERNALSERVER',
    ) {}

    public static function create(
        string $message = 'An unexpected error occurred',
        string $code = 'INTERNALSERVER'
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
