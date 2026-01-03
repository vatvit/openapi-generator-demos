<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

/**
 * BadRequestErrorResponse
 *
 * Error response DTO for HTTP 400 (Bad Request)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class BadRequestErrorResponse
{
    private int $statusCode = 400;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private string $message = 'The request was invalid',
        private string $code = 'BADREQUEST',
    ) {}

    public static function create(
        string $message = 'The request was invalid',
        string $code = 'BADREQUEST'
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
