<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

use TictactoeApi\Model\SquareResponse;

/**
 * GetSquare200Response
 *
 * Response DTO for getSquare - HTTP 200
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class GetSquare200Response
{
    private int $statusCode = 200;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private SquareResponse $data
    ) {}

    public static function create(SquareResponse $data): self
    {
        return new self($data);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): SquareResponse
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
