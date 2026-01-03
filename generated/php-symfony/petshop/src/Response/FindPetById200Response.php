<?php

declare(strict_types=1);

namespace PetshopApi\Api\Response;

use PetshopApi\Model\Pet;

/**
 * FindPetById200Response
 *
 * Response DTO for findPetById - HTTP 200 (pet response)
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class FindPetById200Response
{
    private int $statusCode = 200;

    /** @var array<string, string> */
    private array $headers = [];

    public function __construct(
        private Pet $data
    ) {}

    public static function create(Pet $data): self
    {
        return new self($data);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): Pet
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
