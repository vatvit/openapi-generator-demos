<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Response;


/**
 * DeletePet204Response
 *
 * Response DTO for deletePet - HTTP 204 (pet deleted)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class DeletePet204Response
{
    private int $statusCode = 204;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private mixed $data = null
    ) {}

    public static function create(mixed $data = null): self
    {
        return new self($data);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): mixed
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
