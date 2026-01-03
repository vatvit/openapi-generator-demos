<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

use TictactoeApi\Model\UnauthorizedError;

/**
 * ListGames401Response
 *
 * Response DTO for listGames - HTTP 401 (Unauthorized - Authentication required)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class ListGames401Response
{
    private int $statusCode = 401;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private UnauthorizedError $data
    ) {}

    public static function create(UnauthorizedError $data): self
    {
        return new self($data);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): UnauthorizedError
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
