<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

use TictactoeApi\Model\Status;

/**
 * PutSquare200Response
 *
 * Response DTO for putSquare - HTTP 200
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class PutSquare200Response
{
    private int $statusCode = 200;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private Status $data
    ) {}

    public static function create(Status $data): self
    {
        return new self($data);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): Status
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
