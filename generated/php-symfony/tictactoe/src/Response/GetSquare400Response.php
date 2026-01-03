<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

use TictactoeApi\Model\BadRequestError;

/**
 * GetSquare400Response
 *
 * Response DTO for getSquare - HTTP 400 (Bad Request - Invalid parameters)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class GetSquare400Response
{
    private int $statusCode = 400;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private BadRequestError $data
    ) {}

    public static function create(BadRequestError $data): self
    {
        return new self($data);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): BadRequestError
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
