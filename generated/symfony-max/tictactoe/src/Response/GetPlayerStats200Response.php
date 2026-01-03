<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

use TictactoeApi\Model\PlayerStats;

/**
 * GetPlayerStats200Response
 *
 * Response DTO for getPlayerStats - HTTP 200 (Successful response)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class GetPlayerStats200Response
{
    private int $statusCode = 200;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private PlayerStats $data
    ) {}

    public static function create(PlayerStats $data): self
    {
        return new self($data);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): PlayerStats
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
