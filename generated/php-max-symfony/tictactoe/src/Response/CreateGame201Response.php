<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

use TictactoeApi\Model\Game;

/**
 * CreateGame201Response
 *
 * Response DTO for createGame - HTTP 201 (Game created successfully)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class CreateGame201Response
{
    private int $statusCode = 201;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private Game $data
    ) {}

    public static function create(Game $data): self
    {
        return new self($data);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): Game
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
