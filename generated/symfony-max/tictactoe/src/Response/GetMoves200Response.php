<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;

use TictactoeApi\Model\MoveHistory;

/**
 * GetMoves200Response
 *
 * Response DTO for getMoves - HTTP 200 (Successful response)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class GetMoves200Response
{
    private int $statusCode = 200;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private MoveHistory $data
    ) {}

    public static function create(MoveHistory $data): self
    {
        return new self($data);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): MoveHistory
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
