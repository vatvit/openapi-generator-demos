<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

use TictactoeApi\Model\ForbiddenError;

/**
 * DeleteGame403Response
 *
 * Response DTO for deleteGame - HTTP 403 (Forbidden - Insufficient permissions)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class DeleteGame403Response
{
    private int $statusCode = 403;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private ForbiddenError $data
    ) {}

    public static function create(ForbiddenError $data): self
    {
        return new self($data);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): ForbiddenError
    {
        return $this->data;
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
