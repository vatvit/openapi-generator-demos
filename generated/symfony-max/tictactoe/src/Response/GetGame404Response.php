<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

use TictactoeApi\Model\NotFoundError;

/**
 * GetGame404Response
 *
 * Response DTO for getGame - HTTP 404 (Not Found - Resource does not exist)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class GetGame404Response
{
    private int $statusCode = 404;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private NotFoundError $data
    ) {}

    public static function create(NotFoundError $data): self
    {
        return new self($data);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): NotFoundError
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
