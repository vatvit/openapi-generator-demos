<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

use TictactoeApi\Model\Error;

/**
 * FindPets0Response
 *
 * Response DTO for findPets - HTTP 0 (unexpected error)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class FindPets0Response
{
    private int $statusCode = 0;

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
