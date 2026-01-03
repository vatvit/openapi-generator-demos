<?php

declare(strict_types=1);

namespace PetshopApi\Api\Response;

/**
 * ValidationErrorResponse
 *
 * Error response DTO for HTTP 422 (Unprocessable Entity)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class ValidationErrorResponse
{
    private int $statusCode = 422;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private string $message = 'Validation failed',
        private string $code = 'VALIDATION',
        /** @var array<string, array<string>> */
        private array $errors = []
    ) {}

    public static function create(
        string $message = 'Validation failed',
        string $code = 'VALIDATION',
        array $errors = []
    ): self {
        return new self($message, $code, $errors);
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
            'errors' => $this->errors,
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
