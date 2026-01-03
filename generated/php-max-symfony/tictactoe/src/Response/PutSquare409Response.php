<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

use TictactoeApi\Model\Error;

/**
 * PutSquare409Response
 *
 * Response DTO for putSquare - HTTP 409 (Conflict - Square already occupied or game finished)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class PutSquare409Response
{
    private int $statusCode = 409;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private Error $data
    ) {}

    public static function create(Error $data): self
    {
        return new self($data);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): Error
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
